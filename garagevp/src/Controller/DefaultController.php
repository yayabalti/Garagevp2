<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Repository\VoitureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('index.html.twig', [
            'title' => 'Home Page',
        ]);
    }

    #[Route('/a_propos', name: 'app_a_propos')]
    public function about(): Response
    {
        return $this->render('a_propos.html.twig', [
            'title' => 'À propos',
        ]);
    }

    #[Route('/nos-services', name: 'app_services')]
    public function services(): Response
    {
        return $this->render('nos-services.html.twig', [
            'title' => 'Nos Services',
        ]);
    }

    #[Route('/petites-annonces', name: 'app_petites_annonces')]
    public function petitesAnnonces(Request $request, VoitureRepository $voitureRepository): Response
    {
        try {
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

            return $this->render('petites-annonces/index.html.twig', [
                'title' => 'Petites Annonces',
                'annonces' => $annonces,
            ]);

        } catch (NotFoundHttpException $e) {
            $message = 'Aucune annonce trouvée.';
            if ($referer = $request->headers->get('referer')) {
                $message .= sprintf(' (depuis "%s")', $referer);
            }
            throw new NotFoundHttpException($message, $e);
        } catch (MethodNotAllowedHttpException $e) {
            $message = sprintf('Méthode non autorisée pour "%s %s".', 
                $request->getMethod(), 
                $request->getUriForPath($request->getPathInfo())
            );
            return new Response($message, Response::HTTP_METHOD_NOT_ALLOWED);
        } catch (\Exception $e) {
            throw new \Exception('Une erreur s\'est produite : ' . $e->getMessage(), 0, $e);
        }
    }

    #[Route('/contact', name: 'app_contact')]
    public function contact(): Response
    {
        return $this->render('contact/index.html.twig', [
            'title' => 'Contact',
        ]);
    }
}







