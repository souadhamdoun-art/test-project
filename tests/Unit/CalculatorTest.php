<?php

use App\Services\Calculator;

// Pest syntax - much cleaner than PHPUnit!

it('can add two numbers', function () {
    // Arrange
    $calculator = new Calculator;

    // Act
    $result = $calculator->add(2, 3);

    // Assert
    expect($result)->toBe(5);
});

it('can subtract two numbers', function () {
    // Arrange
    $calculator = new Calculator;

    // Act
    $result = $calculator->subtract(5, 3);

    // Assert
    expect($result)->toBe(2);
});

// Even more elegant Pest syntax
test('calculator multiplication', function () {
    $calculator = new Calculator;

    expect($calculator->multiply(3, 4))->toBe(12);
});

// Using describe for grouping tests
describe('Calculator', function () {
    beforeEach(function () {
        $this->calculator = new Calculator;
    });

    it('divides numbers correctly', function () {
        expect($this->calculator->divide(10, 2))->toBe((float) 5);
    });

    it('handles division by zero', function () {
        expect(fn () => $this->calculator->divide(10, 0))
            ->toThrow(InvalidArgumentException::class);
    });
});

it('test the function toBe', function () {
    expect('2' + '2')->toBe(4);

});

it('test expectation toBeBetween', function () {
    expect(5)->toBeBetween(1, 10);
    expect(1.5)->toBeBetween(1, 2);
});

it('test expectation toBeEmpty', function () {
    // expect('')->toBeEmpty();
    // expect([])->toBeEmpty();
    // expect(null)->toBeEmpty();
    // expect([1, 2, 3])->toContainEqual('1');
    // expect([1, 2, 3])->toContainEqual('1', '2');
    $array = [
        ['id' => 1, 'name' => 'Alice'],
        ['id' => 2, 'name' => 'Bob']
    ];

    expect($array)->toContainEqual(['id' => 2, 'name' => 'Bob']); // passe
    expect($array)->toContain(['id' => 2, 'name' => 'Bob']);      // peut échouer selon l'implémentation

});

it('test expectation toMatchArray', function () {

    $user = [
    'id'    => 1,
    'name'  => 'Nuno',
    'email' => 'enunomaduro@gmail.com',
    'is_active' => true,
    ];

    expect($user)->toMatchArray([
        'email' => 'enunomaduro@gmail.com',
        'name' => 'Nuno'
    ]);
});

it('test expectation toMatchObject', function () {
    $user = new stdClass();
    $user->id = 1;
    $user->name = 'Nuno';
    $user->email = 'enunomaduro@gmail.com';
    $user->is_active = true;
    expect($user)->toMatchObject([
        'email' => 'enunomaduro@gmail.com',
        'name' => 'Nuno'
    ]);
});

it('test expectation toEqualCanonicalizing',function(){
    $usersAsc = ['Dan', 'Fabio', 'Nuno'];
    $usersDesc = ['Nuno', 'Fabio', 'Dan'];

    expect($usersAsc)->toEqualCanonicalizing($usersDesc);
    expect($usersAsc)->not->toEqual($usersDesc);
});

it('test expectation toBeDigits',function(){
    expect(123)->toBeDigits();
    expect('123a')->not->toBeDigits();
});
it('test expectation toHaveKey',function(){
    expect(['name' => 'Nuno', 'surname' => 'Maduro'])->toHaveKey('name');
    expect(['name' => 'Nuno', 'surname' => 'Maduro'])->toHaveKey('name', 'Nuno');
    expect(['user' => ['name' => 'Nuno', 'surname' => 'Maduro']])->toHaveKey('user.name');
    expect(['user' => ['name' => 'Nuno', 'surname' => 'Maduro']])->toHaveKey('user.name', 'Nuno');

});


it('test expectation toHaveSameSize',function(){
    expect('test')->toHaveSameSize('mmmm');
});
it('test the modifier match',function(){
    $user = new stdClass();
    $user->default_language = 'Português';
    $user->country = 'PT';
    // expect($user->default_language)
    // ->match($user->country, [
    //     'PT' => 'Português',
    //     'US' => 'English',
    //     'TR' => 'Türkçe',
    // ]);
    expect($user)
    ->ray() // Debug l'objet user
    ->toBeInstanceOf(stdClass::class)
    ->default_language->toBe('Português');
});

it('test the modifier when',function(){
    $user = new stdClass();
    $user->default_language = 'Português';
    $user->country = 'PT';
    expect($user)
    ->when($user->country === 'PT', fn() => $user->default_language = 'English')
    ->toBeInstanceOf(stdClass::class)
    ->default_language->toBe('English');
});
