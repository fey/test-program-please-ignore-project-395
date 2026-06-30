<?php

namespace hexlet\code;

const LOWERCASE = 'abcdefghijklmnopqrstuvwxyz';
const UPPERCASE = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
const DIGITS    = '0123456789';
const SPECIAL   = '!@#$%^&*';

function nextRandom(int $seed): int
{
    return (16807 * $seed) % 2147483647;
}

function generatePassword(
    int $length,
    int $seed,
    bool $useUppercase = true,
    bool $useDigits = true,
    bool $useSpecial = false
): string {
    $alphabet = LOWERCASE;
    if ($useUppercase) {
        $alphabet .= UPPERCASE;
    }
    if ($useDigits) {
        $alphabet .= DIGITS;
    }
    if ($useSpecial) {
        $alphabet .= SPECIAL;
    }

    $current = $seed;
    $result = '';
    for ($i = 0; $i < $length; $i++) {
        $current = nextRandom($current);
        $result .= $alphabet[$current % strlen($alphabet)];
    }
    return $result;
}

function hasLowercase(string $password): bool
{
    for ($i = 0; $i < strlen($password); $i++) {
        if ($password[$i] >= 'a' && $password[$i] <= 'z') {
            return true;
        }
    }
    return false;
}

function hasUppercase(string $password): bool
{
    for ($i = 0; $i < strlen($password); $i++) {
        if ($password[$i] >= 'A' && $password[$i] <= 'Z') {
            return true;
        }
    }
    return false;
}

function hasDigit(string $password): bool
{
    for ($i = 0; $i < strlen($password); $i++) {
        if ($password[$i] >= '0' && $password[$i] <= '9') {
            return true;
        }
    }
    return false;
}

function hasSpecial(string $password): bool
{
    for ($i = 0; $i < strlen($password); $i++) {
        if (str_contains(SPECIAL, $password[$i])) {
            return true;
        }
    }
    return false;
}

function isLongEnough(string $password, int $minLength = 8): bool
{
    return strlen($password) >= $minLength;
}

function strengthScore(string $password): int
{
    $score = 0;
    if (isLongEnough($password)) {
        $score++;
    }
    if (hasLowercase($password)) {
        $score++;
    }
    if (hasUppercase($password)) {
        $score++;
    }
    if (hasDigit($password)) {
        $score++;
    }
    if (hasSpecial($password)) {
        $score++;
    }
    return $score;
}

function checkPassword(string $password): string
{
    $score = strengthScore($password);
    if ($score <= 2) {
        $verdict = 'Слабый';
    } elseif ($score === 3) {
        $verdict = 'Средний';
    } elseif ($score === 4) {
        $verdict = 'Надёжный';
    } else {
        $verdict = 'Очень надёжный';
    }
    return "{$verdict} пароль (оценка {$score} из 5)";
}
