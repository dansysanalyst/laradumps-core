<?php

function adjustPathToDirectorySeparator(string $path): string
{
    return str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);
}

expect()->extend('toBeUniqId', function () {
    return $this->toMatch('/^[a-f0-9]{13}$/');
});

function isPhp85OrHigher(): bool
{
    return version_compare(PHP_VERSION, '8.5.0', '>=');
}
