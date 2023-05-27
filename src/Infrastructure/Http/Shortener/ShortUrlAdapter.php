<?php

namespace Tleckie\Url\Infrastructure\Http\Shortener;

use GuzzleHttp\ClientInterface;
use Throwable;
use Tleckie\Url\Domain\ShortUrlAdapterInterface;
use Tleckie\Url\Infrastructure\Http\Exceptions\HttpException;

/**
 * Class ShortUrlAdapter
 * @package Tleckie\Url\Infrastructure\Http\Shortener
 */
class ShortUrlAdapter implements ShortUrlAdapterInterface
{
    /** @var ClientInterface */
    private ClientInterface $httpClient;

    /** @var string */
    private string $endpoint;

    /** @var string */
    private string $method;

    /**
     * ShortUrl constructor.
     * @param ClientInterface $httpClient
     * @param string $endpoint
     * @param string $method
     */
    public function __construct(ClientInterface $httpClient, string $endpoint, string $method)
    {
        $this->httpClient = $httpClient;
        $this->endpoint = $endpoint;
        $this->method = $method;
    }

    /**
     * @param string $url
     * @return string
     * @throws HttpException
     */
    public function retrieveShortUrl(string $url): string
    {
        try {

            $response = $this->httpClient->request(
                $this->method,
                \sprintf("%s%s", $this->endpoint, $url)
            );

            return $response->getBody();

        } catch (Throwable $exception) {
            throw new HttpException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }
}
