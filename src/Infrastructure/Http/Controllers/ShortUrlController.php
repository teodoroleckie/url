<?php

namespace Tleckie\Url\Infrastructure\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Validation\ValidationException;
use Tleckie\Url\Application\Shortener\ShortUrlServiceInterface;

/**
 * Class ShortUrlController
 * @package Tleckie\Url\Infrastructure\Http\Controllers
 */
class ShortUrlController extends Controller
{
    /** @var ShortUrlServiceInterface */
    private ShortUrlServiceInterface $service;

    /**
     * ShortUrlController constructor.
     * @param ShortUrlServiceInterface $service
     */
    public function __construct(ShortUrlServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     * @param ResponseFactory $responseFactory
     * @return JsonResponse
     * @throws ValidationException
     */
    public function index(Request $request, ResponseFactory $responseFactory): JsonResponse
    {
        $this->validate($request, [
            'url' => 'required|string',
        ]);

        $url = $this->service->shortenerUrl(
            $request->get('url')
        );

        return $responseFactory->json(
            ['url' => $url->getValue()]
        );
    }
}
