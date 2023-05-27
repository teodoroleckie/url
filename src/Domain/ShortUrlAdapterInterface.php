<?php

namespace Tleckie\Url\Domain;

/**
 * Interface ShortUrlAdapterInterface
 * @package Tleckie\Url\Domain
 */
interface ShortUrlAdapterInterface
{
    /**
     * @param string $url
     * @return string
     */
    public function retrieveShortUrl(string $url): string;
}
