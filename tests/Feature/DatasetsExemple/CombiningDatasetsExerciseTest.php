<?php

use App\Models\Course;
use App\Models\User;

require_once __DIR__ . '/../../Datasets/CourseDataset.php';
require_once __DIR__ . '/../../Datasets/SharedDatasets.php';


    // Exercice 1: Combiner course_types avec difficulty_levels
    it('validates course creation with combined type and difficulty constraints', function ($courseType, $level,$min_rating) {
        $courseData = array_merge($courseType, ['difficulty' => $level]);

        $course = Course::factory()->create($courseData);

        expect($course->title)->toBe($courseType['title']);
        expect($course->difficulty)->toBe($level);

        // Validation des règles métier combinées
        if ($courseType['price'] == 0 && $level === 'expert') {
            // Un cours gratuit ne peut pas être de niveau expert
            expect($course->isValidConfiguration())->toBeFalse();
        } else if ($courseType['price'] > 100 && $level === 'beginner') {
            // Un cours cher ne devrait pas être pour débutants
            expect($course->isPriceAppropriateForLevel())->toBeFalse();
        } else {
            expect($course->isValidConfiguration())->toBeTrue();
        }
    })->with('course_types', 'difficulty_levels');

