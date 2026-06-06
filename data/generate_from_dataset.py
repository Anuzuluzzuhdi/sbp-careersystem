#!/usr/bin/env python3
"""
Generate normalized CSV files from it_career_dataset.csv for Laravel seeders.

Weight formula (per schema_notes.txt):
    weight = frequency / total_occurrence_of_career

Where:
    - frequency       = how often a value appears for a given career
    - total_occurrence_of_career = total rows in dataset for that career

Notes:
    - education, specialization, certification: 1 value per row
      → weights per career sum to ~1.0 (cert slightly less if some rows have no cert)
    - skills: multiple values per row (comma-separated)
      → each skill in a row is counted once; weights sum to >1.0 (expected)
"""

import csv
from collections import defaultdict
from pathlib import Path

DATA_DIR = Path(__file__).parent
DATASET = DATA_DIR / "it_career_dataset.csv"


def write_csv(filename: str, headers: list[str], rows: list) -> None:
    path = DATA_DIR / filename
    with open(path, "w", newline="", encoding="utf-8") as f:
        writer = csv.writer(f)
        writer.writerow(headers)
        writer.writerows(rows)
    print(f"  {filename}: {len(rows)} rows")


def build_weight_rows(freq_map, career_id_map, right_id_map, career_totals):
    rows = []
    weight_sums = defaultdict(float)

    for (career, right), freq in sorted(
        freq_map.items(), key=lambda x: (career_id_map[x[0][0]], right_id_map[x[0][1]])
    ):
        weight = round(freq / career_totals[career], 4)
        rows.append([career_id_map[career], right_id_map[right], freq, weight])
        weight_sums[career] += weight

    return rows, weight_sums


def main() -> None:
    if not DATASET.exists():
        raise FileNotFoundError(f"Dataset not found: {DATASET}")

    records = []
    with open(DATASET, newline="", encoding="utf-8") as f:
        for row in csv.DictReader(f):
            records.append({
                "career": row["Recommended Career"].strip(),
                "education": row["Education Level"].strip(),
                "specialization": row["Specialization"].strip(),
                "skills": [s.strip() for s in row["Skills"].split(",") if s.strip()],
                "certification": row["Certifications"].strip(),
            })

    careers = sorted({r["career"] for r in records})
    educations = sorted({r["education"] for r in records})
    specializations = sorted({r["specialization"] for r in records})
    skills_set = sorted({s for r in records for s in r["skills"]})
    certs_set = sorted({r["certification"] for r in records if r["certification"]})

    career_id = {name: i + 1 for i, name in enumerate(careers)}
    education_id = {name: i + 1 for i, name in enumerate(educations)}
    spec_id = {name: i + 1 for i, name in enumerate(specializations)}
    skill_id = {name: i + 1 for i, name in enumerate(skills_set)}
    cert_id = {name: i + 1 for i, name in enumerate(certs_set)}

    print(f"Processing {len(records)} rows from {DATASET.name}")

    write_csv("careers.csv", ["career_id", "career_name"],
              [[career_id[n], n] for n in careers])
    write_csv("educations.csv", ["education_id", "education_level"],
              [[education_id[n], n] for n in educations])
    write_csv("specializations.csv", ["specialization_id", "specialization_name"],
              [[spec_id[n], n] for n in specializations])
    write_csv("skills.csv", ["skill_id", "skill_name"],
              [[skill_id[n], n] for n in skills_set])
    write_csv("certifications.csv", ["certification_id", "certification_name"],
              [[cert_id[n], n] for n in certs_set])

    career_totals = defaultdict(int)
    edu_freq = defaultdict(int)
    spec_freq = defaultdict(int)
    skill_freq = defaultdict(int)
    cert_freq = defaultdict(int)

    for r in records:
        c = r["career"]
        career_totals[c] += 1
        edu_freq[(c, r["education"])] += 1
        spec_freq[(c, r["specialization"])] += 1
        for s in r["skills"]:
            skill_freq[(c, s)] += 1
        if r["certification"]:
            cert_freq[(c, r["certification"])] += 1

    edu_rows, edu_sums = build_weight_rows(edu_freq, career_id, education_id, career_totals)
    spec_rows, spec_sums = build_weight_rows(spec_freq, career_id, spec_id, career_totals)
    skill_rows, skill_sums = build_weight_rows(skill_freq, career_id, skill_id, career_totals)
    cert_rows, cert_sums = build_weight_rows(cert_freq, career_id, cert_id, career_totals)

    write_csv("career_education_weights.csv",
              ["career_id (FK)", "education_id (FK)", "frequency", "weight"], edu_rows)
    write_csv("career_specialization_weights.csv",
              ["career_id (FK)", "specialization_id (FK)", "frequency", "weight"], spec_rows)
    write_csv("career_skill_weights.csv",
              ["career_id (FK)", "skill_id (FK)", "frequency", "weight"], skill_rows)
    write_csv("career_certification_weights.csv",
              ["career_id (FK)", "certification_id (FK)", "frequency", "weight"], cert_rows)

    print("\nWeight validation (sample careers):")
    sample = ["ML Engineer", "Business Analyst", "Data Entry Operator"]
    for name in sample:
        if name not in career_totals:
            continue
        print(f"  {name} ({career_totals[name]} rows):")
        print(f"    education weight sum     = {edu_sums[name]:.4f}")
        print(f"    specialization weight sum= {spec_sums[name]:.4f}")
        print(f"    skill weight sum         = {skill_sums[name]:.4f}")
        print(f"    certification weight sum = {cert_sums[name]:.4f}")

    print("\nDone.")


if __name__ == "__main__":
    main()
