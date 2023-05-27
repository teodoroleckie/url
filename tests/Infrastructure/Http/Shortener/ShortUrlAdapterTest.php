<?php

namespace Tests\Tleckie\Url\Infrastructure\Http\Shortener;

use Exception;
use GuzzleHttp\ClientInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Tleckie\Url\Infrastructure\Http\Exceptions\HttpException;
use Tleckie\Url\Infrastructure\Http\Shortener\ShortUrlAdapter;

/**
 * Class ShortUrlAdapterTest
 * @package Tests\Tleckie\Url\Infrastructure\Http\Shortener
 */
class ShortUrlAdapterTest extends TestCase
{
    /** @var ShortUrlAdapter */
    private ShortUrlAdapter $adapter;

    /** @var ClientInterface|MockObject */
    private ClientInterface|MockObject $httpClientMock;

    /** @var ResponseInterface|MockObject */
    private ResponseInterface|MockObject $responseMock;

    /** @var StreamInterface|MockObject */
    private StreamInterface|MockObject $streamMock;

    /** @var string */
    private const ENDPOINT = 'https://enpoint.com/test/?url=';

    /** @var string */
    private const SHORTEN = 'https://url-to-shortener.com/';

    /** @var string */
    private const SHORT = 'https://short.com/';

    protected function setUp(): void
    {
        $this->httpClientMock = $this->createMock(ClientInterface::class);
        $this->responseMock = $this->createMock(ResponseInterface::class);
        $this->streamMock = $this->createMock(StreamInterface::class);

        $this->adapter = new ShortUrlAdapter(
            $this->httpClientMock,
            self::ENDPOINT,
            'GET'
        );
    }

    public function testRetrieveShortUrl()
    {
        $this->httpClientMock->expects(static::once())
            ->method('request')
            ->with('GET', self::ENDPOINT . self::SHORTEN)
            ->willReturn($this->responseMock);

        $this->streamMock->expects(static::once())
            ->method('__toString')
            ->willReturn(static::SHORT);

        $this->responseMock->expects(static::once())
            ->method('getBody')
            ->willReturn($this->streamMock);

        $this->assertEquals(
            static::SHORT,
            $this->adapter->retrieveShortUrl(static::SHORTEN)
        );
    }

    public function testHttpException()
    {
        $this->expectException(HttpException::class);
        $this->expectExceptionCode(20);
        $this->expectExceptionMessage('http timeout.');

        $this->httpClientMock->expects(static::once())
            ->method('request')
            ->with('GET', self::ENDPOINT . self::SHORTEN)
            ->willThrowException(new Exception('http timeout.', 20));

        $this->adapter->retrieveShortUrl(static::SHORTEN);
    }
}
