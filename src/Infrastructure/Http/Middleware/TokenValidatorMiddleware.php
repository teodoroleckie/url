<?php
namespace Tleckie\Url\Infrastructure\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tleckie\Url\Application\Exceptions\InvalidAccessTokenException;
use Tleckie\Url\Application\TokenValidator\TokenValidatorInterface;

/**
 * Class TokenValidatorMiddleware
 * @package Tleckie\Url\Infrastructure\Http\Middleware
 */
class TokenValidatorMiddleware {

    /** @var TokenValidatorInterface  */
    private TokenValidatorInterface $tokenValidator;

    /**
     * TokenValidatorMiddleware constructor.
     * @param TokenValidatorInterface $validator
     */
    public function __construct(TokenValidatorInterface $validator)
    {
        $this->tokenValidator = $validator;
    }

    /**
     * @param Request $request
     * @param Closure $next
     * @return Response
     * @throws Exception
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();
        if( null === $token || false === $this->tokenValidator->isValid($token)){
            throw new InvalidAccessTokenException("Invalid access token: {$token}");
        }

        return $next($request);
    }

}
