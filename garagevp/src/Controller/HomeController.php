<?php

// namespace App\Controller;

// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\Routing\Annotation\Route;

// class HomeController extends AbstractController
// {
//     #[Route('/', name: 'app_home')]
//     public function index(): Response
//     {
//         return $this->render('home/index.html.twig', [
//             'title' => 'Home Page',
//         ]);
//     }
// }


// namespace App\Controller;

// use App\Entity\Review;
// use App\Form\ReviewType;
// use App\Repository\ReviewRepository;
// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\Routing\Annotation\Route;
// use Doctrine\ORM\EntityManagerInterface;

// class HomeController extends AbstractController
// {
//    #[Route('/', name: 'app_home')]
//    public function index(Request $request, EntityManagerInterface $em, ReviewRepository $reviewRepository): Response
//    {
//        // Créer le formulaire d'avis
//        $review = new Review();
//        $form = $this->createForm(ReviewType::class, $review);
//        $form->handleRequest($request);

//        // Traiter la soumission du formulaire
//        if ($form->isSubmitted() && $form->isValid()) {
//            $review->setApproved(false); // Par défaut, l'avis n'est pas approuvé
//            $em->persist($review);
//            $em->flush();

//            $this->addFlash('success', 'Merci pour votre avis ! Il sera publié après validation.');
//            return $this->redirectToRoute('app_home');
//        }

//        // Récupérer les avis approuvés pour le carrousel
//        $approvedReviews = $reviewRepository->findApprovedReviews();

//        return $this->render('home/index.html.twig', [
//            'title' => 'Home Page',
//            'reviewForm' => $form->createView(),
//            'approvedReviews' => $approvedReviews
//        ]);
//    }
// }

namespace App\Controller;

use App\Entity\Review;
use App\Form\ReviewType;
use App\Repository\ReviewRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request, EntityManagerInterface $em, ReviewRepository $reviewRepository): Response
    {
        // Créer le formulaire d'avis
        $review = new Review();
        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);

        // Traiter la soumission du formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            $review->setApproved(false); // Par défaut, l'avis n'est pas approuvé
            $em->persist($review);
            $em->flush();

            $this->addFlash('success', 'Merci pour votre avis ! Il sera publié après validation.');
            return $this->redirectToRoute('app_home');
        }

        // Récupérer les avis approuvés pour le carrousel
        $approvedReviews = $reviewRepository->findApprovedReviews(); // Utilisation de la méthode pour récupérer les avis approuvés

        // Rendre la page avec le formulaire et les avis approuvés
        return $this->render('home/index.html.twig', [
            'title' => 'Home Page', // Titre de la page (modifiable dans le template)
            'reviewForm' => $form->createView(), // Affichage du formulaire
            'approvedReviews' => $approvedReviews // Avis approuvés à afficher
        ]);
    }
}
