<?php

namespace Tleckie\Url\Application\TokenValidator;

/**
 * Interface TokenValidatorInterface
 * @package Tleckie\Url\Application\TokenValidator
 */
interface TokenValidatorInterface
{
    /**
     * @param string $token
     * @return bool
     */
    public function isValid(string $token): bool;
}
