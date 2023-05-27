<?php

namespace Tleckie\Url\Application\Shortener;

use Tleckie\Url\Domain\ShortUrl;
use Tleckie\Url\Domain\ShortUrlFactoryInterface;

/**
 * Class ShortUrlFactory
 * @package Tleckie\Url\Application\Shortener
 */
class ShortUrlFactory implements ShortUrlFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildShortUrl(string $url): ShortUrl
    {
        return new ShortUrl($url);
    }
}
