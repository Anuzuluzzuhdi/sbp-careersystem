<?php

namespace App\Support;

use Illuminate\Support\Collection;

class SkillCategoryGrouper
{
    private const CATEGORY_MAP = [
        'Computer Science Fundamentals' => [
            'Data Structures & Algorithms',
            'OOP',
            'Design Patterns',
            'System Design',
            'Problem Solving',
            'Analytical Thinking',
        ],
        'Programming Languages' => [
            'Python',
            'Java',
            'JavaScript',
            'TypeScript',
            'C',
            'C#',
            'C++',
            'Go',
            'Rust',
            'Ruby',
            'PHP',
            'R',
            'Swift',
            'Kotlin',
            'Scala',
            'Bash/Shell Scripting',
            'PowerShell',
        ],
        'Web Development' => [
            'HTML',
            'CSS',
            'React',
            'Vue',
            'Angular',
            'Next.js',
            'Node.js',
            'Express',
            'GraphQL',
            'REST API',
        ],
        'Backend Frameworks' => [
            'Laravel',
            'Django',
            'Flask',
            'Spring Boot',
            'Microservices',
        ],
        'Mobile Development' => [
            'Flutter',
            'React Native',
            'Kotlin/Java (Android)',
            'Swift (iOS)',
            'Jetpack Compose',
        ],
        'Data Science & Machine Learning' => [
            'Machine Learning',
            'PyTorch',
            'TensorFlow',
            'Scikit-learn',
            'NumPy',
            'Pandas',
            'Spark',
            'Hadoop',
            'Data Analysis',
            'Tableau',
            'Power BI',
        ],
        'Database' => [
            'SQL',
            'MySQL',
            'PostgreSQL',
            'MongoDB',
            'Redis',
            'SQLite',
            'Cassandra',
            'Elasticsearch',
        ],
        'Cloud & DevOps' => [
            'AWS',
            'Azure',
            'Google Cloud',
            'Docker',
            'Kubernetes',
            'Terraform',
            'Ansible',
            'Jenkins',
            'CI/CD',
            'GitHub Actions',
            'GitLab',
            'Load Balancer',
        ],
        'Cybersecurity' => [
            'Kali Linux',
            'Metasploit',
            'Burp Suite',
            'Penetration Testing',
            'OWASP',
            'SIEM',
            'Wireshark',
            'Cryptography',
            'Firewall',
            'VPN',
        ],
        'Networking' => [
            'DNS',
            'TCP/IP',
            'HTTP/HTTPS',
            'OSI Model',
            'Subnetting',
        ],
        'Operating Systems' => [
            'Linux (Ubuntu)',
            'CentOS',
            'Debian',
            'Windows Server',
        ],
        'Development Tools' => [
            'Git',
            'GitHub',
            'Bitbucket',
            'Jira',
            'Confluence',
            'Notion',
            'Agile/Scrum',
            'Firebase',
        ],
        'Business & Communication' => [
            'Communication',
            'Accounting',
            'Financial Analysis',
            'Marketing',
            'MS Office',
            'Counseling',
            'Technical Writing',
        ],
    ];

    public static function group(Collection $skills): array
    {
        $skillsByName = $skills->keyBy('skill_name');
        $grouped = [];
        $assigned = [];

        foreach (self::CATEGORY_MAP as $category => $skillNames) {
            $items = [];

            foreach ($skillNames as $skillName) {
                $skill = $skillsByName->get($skillName);

                if ($skill) {
                    $items[] = $skill;
                    $assigned[$skillName] = true;
                }
            }

            if ($items !== []) {
                $grouped[$category] = $items;
            }
        }

        $uncategorized = $skills
            ->filter(fn ($skill) => ! isset($assigned[$skill->skill_name]))
            ->values()
            ->all();

        if ($uncategorized !== []) {
            $grouped['Lainnya'] = $uncategorized;
        }

        return $grouped;
    }
}
