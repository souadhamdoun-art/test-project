<?php

    dataset('permission_scenarios', [
       [['authenticated' => false, 'role' => null, 'can_review' => false]] ,
       [['authenticated' => true, 'role' => 'student', 'can_review' => false]] ,
       [['authenticated' => true, 'role' => 'student', 'can_review' => true]] ,
       [['authenticated' => true, 'role' => 'instructor', 'can_review' => true]] ,
       [['authenticated' => true, 'role' => 'admin', 'can_review' => true]]
    ]);

    dataset('review_comments', [
        'short_positive' => 'Great!',
        'detailed_positive' => 'This course exceeded my expectations. The instructor explains complex concepts clearly.',
        'short_negative' => 'Bad course',
        'detailed_negative' => 'The course content is outdated and the examples do not work properly.',
        'mixed_review' => 'Good content but poor audio quality makes it hard to follow.',
        'empty_comment' => ''
    ]);
    dataset('pricing_strategies', [
        [ ['price' => 0, 'discount' => 0, 'expected_final' => 0]],
        [ ['price' => 29.99, 'discount' => 0, 'expected_final' => 29.99]],
        [ ['price' => 99.99, 'discount' => 10, 'expected_final' => 89.99]],
        [ ['price' => 199.99, 'discount' => 50, 'expected_final' => 99.995]],
        [ ['price' => 299.99, 'discount' => 0, 'expected_final' => 299.99]]
    ]);

