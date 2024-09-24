<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Repository\VoitureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class petites_annoncesController extends AbstractController
{
    #[Route('/petites_annonces', name: 'app_petites_annonces')]
    public function petitesAnnonces(Request $request, VoitureRepository $voitureRepository): Response
    {
        $minPrice = $request->query->get('minPrice');
        $maxPrice = $request->query->get('maxPrice');
        $minKm = $request->query->get('minKm');
        $maxKm = $request->query->get('maxKm');
        $minYear = $request->query->get('minYear');
        $maxYear = $request->query->get('maxYear');

        $annonces = $voitureRepository->findAll();

        // Appliquer les filtres
        $annonces = array_filter($annonces, function(Voiture $annonce) use ($minPrice, $maxPrice, $minKm, $maxKm, $minYear, $maxYear) {
            return (!$minPrice || $annonce->getPrix() >= $minPrice) &&
                   (!$maxPrice || $annonce->getPrix() <= $maxPrice) &&
                   (!$minKm || $annonce->getKilometrage() >= $minKm) &&
                   (!$maxKm || $annonce->getKilometrage() <= $maxKm) &&
                   (!$minYear || $annonce->getAnneeMiseEnCirculation()->format('Y') >= $minYear) &&
                   (!$maxYear || $annonce->getAnneeMiseEnCirculation()->format('Y') <= $maxYear);
        });

        return $this->render('petites_annonces/index.html.twig', [
            'title' => 'Petites Annonces',
            'annonces' => $annonces,
        ]);
    }
}
