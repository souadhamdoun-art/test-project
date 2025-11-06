<?php

use App\Models\Course;
use App\Models\User;

describe('Bound Datasets Test', function () {

    beforeEach(function () {
        $this->user = User::factory()->create();
        $this->courses = Course::factory()->count(3)->create();
        $this->user->purchasedCourses()->attach($this->courses->pluck('id'));
    });

    // ✅ SOLUTION PEST V3 : Utiliser lazy()
    it('teste avec lazy dataset', function ($course) {
        expect($course)->toBeInstanceOf(Course::class);
        expect($this->user->purchasedCourses->contains($course))->toBeTrue();
    })->with([
        fn() => $this->courses[0],
        fn() => $this->courses[1],
        fn() => $this->courses[2],
    ]);

});
