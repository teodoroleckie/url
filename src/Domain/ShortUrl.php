<?php

namespace Tleckie\Url\Domain;

/**
 * Class ShortenerUrl
 * @package Tleckie\url\Domain
 */
class ShortUrl
{

    /** @var string  */
    private string $url;

    /**
     * SharedUrl constructor.
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->url;
    }
}
