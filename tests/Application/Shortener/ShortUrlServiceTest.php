<?php

namespace Tests\Tleckie\Url\Application\Shortener;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tleckie\Url\Application\Shortener\ShortUrlService;
use Tleckie\Url\Domain\ShortUrl;
use Tleckie\Url\Domain\ShortUrlAdapterInterface;
use Tleckie\Url\Domain\ShortUrlFactoryInterface;

/**
 * Class ShortUrlServiceTest
 * @package Tests\Tleckie\Url\Application\Shortener
 */
class ShortUrlServiceTest extends TestCase
{
    /** @var ShortUrlAdapterInterface|MockObject  */
    private ShortUrlAdapterInterface|MockObject $adapterMock;

    /** @var ShortUrlFactoryInterface|MockObject  */
    private ShortUrlFactoryInterface|MockObject $factoryMock;

    protected function setUp(): void
    {
        $this->adapterMock = $this->createMock(
            ShortUrlAdapterInterface::class
        );

        $this->factoryMock = $this->createMock(
            ShortUrlFactoryInterface::class
        );
    }

    public function testShortenerUrl()
    {
        $url = 'https://www.test.com';
        $shortUrl = 'https://short.com/12s';

        $this->adapterMock->expects(static::once())
            ->method('retrieveShortUrl')
            ->with($url)
            ->willReturn($shortUrl);

        $this->factoryMock->expects(static::once())
            ->method('buildShortUrl')
            ->with($shortUrl)
            ->willReturn(new ShortUrl($shortUrl));

        $service = new ShortUrlService(
            $this->adapterMock,
            $this->factoryMock
        );

        $this->assertEquals(
            $service->shortenerUrl($url)->getValue(), $shortUrl
        );

    }


}
