<?php

namespace App\Service\Url;

use App\Entity\Url;
use App\Repository\UrlRepository;
use Doctrine\ORM\EntityManagerInterface;

class UrlService
{
    private UrlRepository $urlRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(
        UrlRepository $urlRepository,
        EntityManagerInterface $entityManager
    )
    {
        $this->urlRepository = $urlRepository;
        $this->entityManager = $entityManager;
    }

    public function createOrFindByUrl(string $url): Url
    {
        if ($this->urlRepository->isExistUrl($url)) {
            return $this->urlRepository->findOneByUrl($url);
        }

        $newUrl = new Url();
        $newUrl->setUrl($url);

        $this->entityManager->persist($newUrl);
        $this->entityManager->flush();

        return $newUrl;
    }
}
