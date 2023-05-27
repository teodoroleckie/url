<?php

namespace Tests\Tleckie\Url\Application\TokenValidator;

use PHPUnit\Framework\TestCase;
use Tleckie\Url\Application\TokenValidator\TokenValidator;

/**
 * Class TokenValidatorTest
 * @package Tests\Tleckie\Url\Application\TokenValidator
 */
class TokenValidatorTest extends TestCase
{
    /** @var TokenValidator */
    private TokenValidator $validator;

    protected function setUp(): void
    {
        $this->validator = new TokenValidator(
            '/^[{}()\[\]]+$/',
            ['{' => '}', '[' => ']', '(' => ')']
        );
    }

    /**
     * @dataProvider retrieveValidToken
     */
    public function testIsValidThenReturnTrue(string $str)
    {
        $this->assertTrue($this->validator->isValid($str));

    }

    /**
     * @dataProvider retrieveInvalidToken
     */
    public function testIsNotValidThenReturnFalse(string $str)
    {
        $this->assertFalse($this->validator->isValid($str));

    }

    public static function retrieveValidToken(): array
    {
        return [
            [''],
            ['[]'],
            ['[()]'],
            ['{[()]}()'],
            ['[]{}()[()]']
        ];
    }

    public static function retrieveInvalidToken(): array
    {
        return [
            ['r'],
            ['[]{'],
            ['[(V)]'],
            ['[()]}()'],
            ['[]{}()[()]2']
        ];
    }

}
