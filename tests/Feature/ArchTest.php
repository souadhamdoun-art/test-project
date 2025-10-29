<?php
namespace Tests\Feature;

use Illuminate\Support\Facades\Validator;

it('finds missing debug statements', function () {

    expect(['dd','dump','ray'])->not->toBeUsed();
});

it('does not use validator facade', function () {
    expect(Validator::class)->not->toBeUsed()
    ->ignoring('App\Actions\Fortify');
});
