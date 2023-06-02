<?php

namespace App\Command;

use App\Repository\UrlRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UpdateIsExpiredStatusCommand extends Command
{
    protected static $defaultName = 'cli:update-is-expired-status';
    protected static $defaultDescription = 'Update isExpired status based on ttl';

    private UrlRepository $urlRepository;
    public function __construct(
        UrlRepository $urlRepository
    )
    {
        parent::__construct();
        $this->urlRepository = $urlRepository;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->urlRepository->updateIsExpired();

        $io->success('Done.');

        return Command::SUCCESS;
    }
}
