<?php

namespace App\Service\Url;

use App\Entity\Url;
use App\Output\Factory\UrlOutputFactory;
use App\Repository\UrlRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class UrlService
{
    private UrlRepository $urlRepository;
    private EntityManagerInterface $entityManager;
    private HttpClientInterface $client;

    public function __construct(
        UrlRepository          $urlRepository,
        EntityManagerInterface $entityManager,
        HttpClientInterface        $client
    )
    {
        $this->urlRepository = $urlRepository;
        $this->entityManager = $entityManager;
        $this->client = $client;
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

    public function sendToEndpoint(Url $url): void
    {
        $endpoint = $_ENV['SECRET_ENDPOINT'];
        $payload = json_encode((new UrlOutputFactory())->create($url), JSON_THROW_ON_ERROR);
//        $client = new \GuzzleHttp\Client();
        $response = $this->client->request('POST', $endpoint, [
            'headers' => ['content-type' => 'json'],
            'body' => $payload
        ]);

        var_dump($response);
    }
}
