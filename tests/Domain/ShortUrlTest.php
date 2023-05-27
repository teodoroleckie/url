<?php

namespace Tests\Tleckie\Url\Domain;

use PHPUnit\Framework\TestCase;
use Tleckie\Url\Domain\ShortUrl;

/**
 * Class ShortUrlTest
 * @package Tests\Tleckie\Url\Domain
 */
class ShortUrlTest extends TestCase
{
    public function testGetValue()
    {
        $url = 'https://www.test.es';

        $shortUrl = new ShortUrl($url);

        $this->assertEquals($shortUrl->getValue(), $url);
    }

}
