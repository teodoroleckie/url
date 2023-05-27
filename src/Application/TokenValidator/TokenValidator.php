<?php

namespace Tleckie\Url\Application\TokenValidator;

/**
 * Class TokenValidator
 * @package Tleckie\Url\Application\TokenValidator
 */
class TokenValidator implements TokenValidatorInterface
{
    /** @var string  */
    private string $pattern;

    /** @var array  */
    private array $nestedTags;

    /**
     * TokenValidator constructor.
     * @param string $pattern
     * @param array $nestedTags
     */
    public function __construct(string $pattern, array $nestedTags)
    {
        $this->pattern = $pattern;
        $this->nestedTags = $nestedTags;
    }

    /**
     * {@inheritdoc}
     */
    public function isValid(string $token): bool
    {
        if(empty($token)){
            return true;
        }

        if (0 === preg_match($this->pattern, $token)) {
            return false;
        }

        $stack = [];
        foreach (str_split($token) as $character) {
            if (array_key_exists($character, $this->nestedTags)) {
                array_push($stack, $character);
            } elseif (in_array($character, $this->nestedTags)) {
                if (empty($stack) || $this->nestedTags[array_pop($stack)] !== $character) {
                    return false;
                }
            }
        }

        return empty($stack);
    }
}
