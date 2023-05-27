<?php

namespace Tleckie\Url\Application\Shortener;

use Tleckie\Url\Domain\ShortUrl;

/**
 * Interface ShortUrlServiceInterface
 * @package Tleckie\Url\Application\Shortener
 */
interface ShortUrlServiceInterface
{
    /**
     * @param string $url
     * @return ShortUrl
     */
    public function shortenerUrl(string $url): ShortUrl;
}
