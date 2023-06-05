<?php

namespace App\Command;

use App\Entity\Url;
use App\Repository\UrlRepository;
use App\Service\Url\UrlService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SendUrlsToEndpointCommand extends Command
{
    protected static $defaultName = 'cli:send-urls-to-endpoint';
    protected static $defaultDescription = 'Send new urls to endpoint';

    private UrlRepository $urlRepository;
    private UrlService $urlService;
    private EntityManagerInterface $entityManager;

    public function __construct(
        UrlRepository          $urlRepository,
        EntityManagerInterface $entityManager,
        UrlService             $urlService
    )
    {
        parent::__construct();
        $this->urlRepository = $urlRepository;
        $this->urlService = $urlService;
        $this->entityManager = $entityManager;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $unhandledUrls = $this->urlRepository->findAllUnprocessed();
        $countUrls = count($unhandledUrls);
        $output->writeln('Found ' . $countUrls . ' records');

        /** @var Url $url */
        foreach ($unhandledUrls as $url) {
            $this->urlService->sendToEndpoint($url);
            $url->setIsSendToEndpoint(true);
            $this->entityManager->persist($url);
        }

        $this->entityManager->flush();

        $io->success('Successfully send ' . $countUrls . ' urls.');

        return Command::SUCCESS;
    }
}
