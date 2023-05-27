<?php

namespace Tleckie\Url\Domain;

/**
 * Interface ShortenerUrlFactoryInterface
 * @package Tleckie\Url\Domain
 */
interface ShortUrlFactoryInterface
{
    /**
     * @param string $url
     * @return ShortUrl
     */
    public function buildShortUrl(string $url): ShortUrl;
}
