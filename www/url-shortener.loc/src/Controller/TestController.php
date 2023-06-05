<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @Route("/send", name="send", methods={"POST"})
     */
    //это тестовый контроллер для проверки того что все данные прилетают
    public function index(Request $request, LoggerInterface $logger): Response
    {
        $json_decode = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $logger->info('Send-To-Endpoint', $json_decode);

        return $this->json([
            'data' => 'All done.',
        ]);
    }
}
