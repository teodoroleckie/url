<?php

namespace Tests\Tleckie\Url\Infrastructure\Http\Middleware;

use Illuminate\Http\Request;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Tleckie\Url\Application\Exceptions\InvalidAccessTokenException;
use Tleckie\Url\Application\TokenValidator\TokenValidatorInterface;
use Tleckie\Url\Infrastructure\Http\Middleware\TokenValidatorMiddleware;

/**
 * Class TokenValidatorMiddlewareTest
 * @package Tests\Tleckie\Url\Infrastructure\Http\Middleware
 */
class TokenValidatorMiddlewareTest extends TestCase
{
    /** @var TokenValidatorMiddleware */
    private TokenValidatorMiddleware $middleware;

    /** @var TokenValidatorInterface|MockObject */
    private TokenValidatorInterface|MockObject $validatorMock;

    /** @var Request|MockObject */
    private Request|MockObject $requestMock;

    /** @var Response|MockObject */
    private Response|MockObject $responseMock;

    protected function setUp(): void
    {
        $this->validatorMock = $this->createMock(
            TokenValidatorInterface::class
        );

        $this->middleware = new TokenValidatorMiddleware(
            $this->validatorMock
        );

        $this->requestMock = $this->createMock(Request::class);

        $this->responseMock = $this->createMock(Response::class);
    }

    public function testNullTokenThrowInvalidAccessTokenException()
    {
        $token = null;
        $this->expectException(InvalidAccessTokenException::class);
        $this->expectExceptionMessage("Invalid access token: {$token}");

        $this->middleware->handle($this->requestMock, function () {
        });
    }

    public function testThrowInvalidAccessTokenException()
    {
        $token = '[';
        $this->expectException(InvalidAccessTokenException::class);
        $this->expectExceptionMessage("Invalid access token: {$token}");

        $this->requestMock->expects(static::once())
            ->method('bearerToken')
            ->willReturn($token);

        $this->validatorMock->expects(static::once())
            ->method('isValid')
            ->with($token)
            ->willReturn(false);

        $this->middleware->handle($this->requestMock, function () {
        });
    }

    /**
     * @dataProvider retrieveValidToken
     */
    public function testValidToken(string $token)
    {
        $this->requestMock->expects(static::once())
            ->method('bearerToken')
            ->willReturn($token);

        $this->validatorMock->expects(static::once())
            ->method('isValid')
            ->with($token)
            ->willReturn(true);

        $response = $this->responseMock;
        $response = $this->middleware->handle($this->requestMock, function () use ($response) {
            return $response;
        });

        $this->assertEquals($response, $this->responseMock);
    }

    public static function retrieveValidToken(): array
    {

        return [
            ['[(){}]'],
            ['']
        ];
    }


}
