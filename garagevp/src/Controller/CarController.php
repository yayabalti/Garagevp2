<?php

namespace App\Controller;

use App\Entity\Car;
use App\Form\CarFilterType;
use App\Repository\CarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CarController extends AbstractController
{
    #[Route('/cars', name: 'car_index')]
    public function index(Request $request, CarRepository $carRepository)
    {
        // Créer un formulaire de filtre
        $form = $this->createForm(CarFilterType::class);
        $form->handleRequest($request);

        $filters = [];
        if ($form->isSubmitted() && $form->isValid()) {
            $filters = $form->getData();
        }

        // Récupérer les voitures filtrées
        $cars = $carRepository->filterCars($filters)->getQuery()->getResult();

        return $this->render('car/index.html.twig', [
            'cars' => $cars,
            'form' => $form->createView(),
        ]);
    }
}
