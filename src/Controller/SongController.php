<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SongController extends AbstractController
{
    #[Route('/api/songs/{id<\d+>}', methods: ['GET'], name: "api_get_info")]
    public function getSong(int $id, LoggerInterface $logger): Response
    {
        $data = [
            'id' => $id,
            'name' => 'Republic',
            'url' => '/mp3/RepublicTheme.mp3',
            /*'id' => $id,
            'name' => 'Separatist',
            'url' => '/mp3/SeparatistTheme.mp3',*/
        ];

        $logger->info('Returning API response for info {info}', [
            'info' => $id,
        ]);

        return new JsonResponse($data);#$this->json($data);
    }
}