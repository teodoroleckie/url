<?php

namespace Tests\Tleckie\Url\Application\Shortener;

use PHPUnit\Framework\TestCase;
use Tleckie\Url\Application\Shortener\ShortUrlFactory;

/**
 * Class ShortUrlFactoryTest
 * @package Tests\Tleckie\Url\Application\Shortener
 */
class ShortUrlFactoryTest extends TestCase
{
    public function testBuildShortUrl()
    {
        $url = 'https://www.test.es';

        $shortUrlFactory = new ShortUrlFactory();
        $shortUrl = $shortUrlFactory->buildShortUrl($url);

        $this->assertEquals($shortUrl->getValue(), $url);
    }

}
