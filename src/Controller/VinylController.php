<?php

namespace App\Controller;

use Psr\Cache\CacheItemInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\MixRepository;
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
    public function browse(MixRepository $mixRepository, string $slug = null): Response
    {
        $genre = $slug ? u(str_replace('-', ' ', $slug))->title(true) : null;
        $mixes = $mixRepository->findAll();
        return $this->render('vinyl/browse.html.twig', [
            'genre' => $genre,
            'mixes' => $mixes,
        ]);
    }
}