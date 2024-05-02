<?php

namespace App\Controller;

use Psr\Cache\CacheItemInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
#use Twig\Environment;

use function Symfony\Component\String\u;

class VinylController extends AbstractController
{
    #[Route("/", name: "app_homepage")]
    public function bambo(/*Environment $twig*/): Response
    {
        $randomList = [
            ["side" => "Republic", "champion" => "Anakin Skywalker"],
            ["side" => "Separatist", "champion" => "Count Dooku"],
            ["side" => "Empire", "champion" => "Darth Vader"],
        ];

        return $this->render("vinyl/homepage.html.twig", [#$html = $twig->render
            "title" => "BIMBIRAMBAM",
            "list" => $randomList,
        ]);

        #return new Response($html);
    }

    #[Route("/browse/{slug}", name: "app_browse")]
    public function browse(HttpClientInterface $httpClient, CacheInterface $cache, string $slug = null): Response
    {
        $genre = $slug ? u(str_replace("-", " ", $slug))->title(true) : null;
        
        $mixes = $cache->get('mixes_data', function(CacheItemInterface $cacheItem) use ($httpClient) 
        {
            $cacheItem->expiresAfter(5);
            $response = $httpClient->request('GET', 'https://raw.githubusercontent.com/SymfonyCasts/vinyl-mixes/main/mixes.json');

            return $response->toArray();
        });
        
        
        return $this->render("vinyl/browse.html.twig", [
            "genre" => $genre,
            "mixes" => $mixes,
        ]);
    }

    private function getMixes(): array {
        return [
            [
                'title' => 'obiwan',
                'trackCount' => 14,
                'genre' => 'Republic',
                'createdAt' => new \DateTime("2021-10-02"),
            ],
            [
                'title' => 'dooku',
                'trackCount' => 8,
                'genre' => 'Separatist',
                'createdAt' => new \DateTime("2022-08-17"),
            ],
            [
                'title' => 'jaba',
                'trackCount' => 10,
                'genre' => 'Huts',
                'createdAt' => new \DateTime("2020-07-21"),
            ],
        ];
    }
}