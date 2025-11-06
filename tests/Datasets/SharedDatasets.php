<?php

// Datasets partagés entre différents modules de test

// Fonction helper pour obtenir les données de difficulté
function getDifficultyLevelsData() {
    return [
        ['beginner', 1],
        ['intermediate', 3],
        ['advanced', 4],
        ['expert', 5]
    ];
}

// Fonction helper pour obtenir les données de méthodes de paiement
function getPaymentMethodsData() {
    return [
        [['method' => 'credit_card', 'fee' => 2.9]],
        [['method' => 'paypal', 'fee' => 3.4]],
        [['method' => 'bank_transfer', 'fee' => 0.5]]
    ];
}

// Fonction helper pour obtenir les statuts de commande
function getOrderStatusesData() {
    return [
        ['pending'],
        ['completed'],
        ['cancelled'],
        ['refunded']
    ];
}

// Fonction helper pour obtenir les langues supportées
function getSupportedLanguagesData() {
    return [
        [['code' => 'en', 'name' => 'English']],
        [['code' => 'fr', 'name' => 'Français']],
        [['code' => 'es', 'name' => 'Español']]
    ];
}

// Datasets traditionnels (pour compatibilité)
dataset('order_statuses', [
    'pending' => 'pending',
    'completed' => 'completed',
    'cancelled' => 'cancelled',
    'refunded' => 'refunded'
]);

dataset('payment_methods', [
    [['method' => 'credit_card', 'fee' => 2.9]],
    [['method' => 'paypal', 'fee' => 3.4]],
    [['method' => 'bank_transfer', 'fee' => 0.5]]
]);

dataset('difficulty_levels', [
    ['level' => 'beginner', 'min_rating' => 1],
    ['level' => 'intermediate', 'min_rating' => 3],
    ['level' => 'advanced', 'min_rating' => 4],
    ['level' => 'expert', 'min_rating' => 5]
]);

dataset('supported_languages', [
    'english' => ['code' => 'en', 'name' => 'English'],
    'french' => ['code' => 'fr', 'name' => 'Français'],
    'spanish' => ['code' => 'es', 'name' => 'Español']
]);
