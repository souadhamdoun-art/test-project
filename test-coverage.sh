#!/bin/bash

# Run tests with code coverage
XDEBUG_MODE=coverage php artisan test --coverage "$@"
