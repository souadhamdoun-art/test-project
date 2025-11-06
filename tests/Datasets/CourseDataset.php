<?php

// Datasets spécifiques aux cours

// Dataset pour les types de cours
dataset('course_types', [
    [[
        'title' => 'Free Laravel Basics',
        'price' => 0,
        'is_published' => true,
        'tagline' => 'Learn Laravel for free'
    ]

    ],
    [
        [
            'title' => 'Advanced Laravel Mastery',
            'price' => 199.99,
            'is_published' => true,
            'tagline' => 'Master advanced Laravel concepts'
        ],
    ],
    [
        [
            'title' => 'Upcoming Vue.js Course',
            'price' => 99.99,
            'is_published' => false,
            'tagline' => 'Coming soon'
        ]
    ]
]);

// Dataset pour les rôles utilisateur
dataset('user_roles', [
    'student' => [
        'role' => 'student',
        'is_premium' => false,
        'email_verified_at' => now()
    ],
    'premium_student' => [
        'role' => 'student',
        'is_premium' => true,
        'email_verified_at' => now()
    ],
    'instructor' => [
        'role' => 'instructor',
        'is_premium' => true,
        'email_verified_at' => now()
    ],
    'admin' => [
        'role' => 'admin',
        'is_premium' => true,
        'email_verified_at' => now()
    ]
]);

// Dataset pour les notes de review
dataset('review_ratings', [1, 2, 3, 4, 5]);
