<?php

namespace Tleckie\Url\Application\Shortener;

use Tleckie\Url\Domain\ShortUrl;
use Tleckie\Url\Domain\ShortUrlAdapterInterface;
use Tleckie\Url\Domain\ShortUrlFactoryInterface;

/**
 * Class ShortUrlService
 * @package Tleckie\Url\Application\Shortener
 */
class ShortUrlService implements ShortUrlServiceInterface
{
    /** @var ShortUrlAdapterInterface */
    private ShortUrlAdapterInterface $adapter;

    /** @var ShortUrlFactoryInterface */
    private ShortUrlFactoryInterface $factory;

    /**
     * ShortenerUrlService constructor.
     * @param ShortUrlAdapterInterface $adapter
     * @param ShortUrlFactoryInterface $factory
     */
    public function __construct(ShortUrlAdapterInterface $adapter, ShortUrlFactoryInterface $factory)
    {
        $this->adapter = $adapter;
        $this->factory = $factory;
    }

    /**
     * {@inheritdoc}
     */
    public function shortenerUrl(string $url): ShortUrl
    {
        $shortUrl = $this->adapter->retrieveShortUrl($url);

        return $this->factory->buildShortUrl($shortUrl);
    }


}
