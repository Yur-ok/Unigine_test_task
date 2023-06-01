<?php

namespace App\Controller;

use App\Entity\Url;
use App\Repository\UrlRepository;
use App\Service\Url\UrlHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\Url\UrlService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UrlController extends AbstractController
{
    private UrlRepository $urlRepository;
    private UrlHelper $urlHelper;
    private UrlService $urlService;

    public function __construct(
        UrlRepository $urlRepository,
        UrlHelper     $urlHelper,
        UrlService    $urlService
    )
    {
        $this->urlRepository = $urlRepository;
        $this->urlHelper = $urlHelper;
        $this->urlService = $urlService;
    }

    /**
     * @Route("/encode-url", name="encode_url")
     */
    public function encodeUrl(Request $request): JsonResponse
    {
        $url = $this->urlService->createOrFindByUrl($request->get('url'));
        return $this->json([
            'hash' => $url->getHash()
        ]);
    }

    /**
     * @Route("/decode-url", name="decode_url")
     */
    public function decodeUrl(Request $request): JsonResponse
    {
//        /** @var UrlRepository $urlRepository */
//        $this->urlRepository = $this->getDoctrine()->getRepository(Url::class);
        $url = $this->urlRepository->findOneByHash($request->get('hash'));
        if ($url === null) {
            return $this->json([
                'error' => 'Non-existent hash.'
            ]);
        }
        return $this->json([
            'url' => $url->getUrl()
        ]);
    }

    /**
     * @Route("/go-url", name="go_url")
     * @param Request $request
     * @return RedirectResponse
     */
    public function goUrl(Request $request): RedirectResponse
    {
        $url = $this->urlRepository->findOneByHash($request->get('hash'));

        if ($url === null) {
            $this->createNotFoundException('Non-existent hash');
        }

        return $this->redirect($this->urlHelper->addScheme($url->getUrl()));
    }
}
