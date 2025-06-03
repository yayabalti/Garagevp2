<?php

// namespace App\Controller;


// use App\Form\CarFilterType; 
// use App\Repository\CarRepository;
// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\Routing\Annotation\Route;

// class CarController extends AbstractController
// {
//     #[Route('/cars', name: 'car_index')]
//     public function index(Request $request, CarRepository $carRepository)
//     {
//         // Créer un formulaire de filtre
//         $form = $this->createForm(CarFilterType::class);
//         $form->handleRequest($request);

//         $filters = [];
//         if ($form->isSubmitted() && $form->isValid()) {
//             $filters = $form->getData();
//         }

//         // Récupérer les voitures filtrées
//         $cars = $carRepository->filterCars($filters)->getQuery()->getResult();

//         return $this->render('car/index.html.twig', [
//             'cars' => $cars,
//             'form' => $form->createView(),
//         ]);
//     }

//     #[Route('/cars/{id}/edit', name: 'car_edit')]
//     public function edit(int $id, Request $request, CarRepository $carRepository)
//     {
//         $car = $carRepository->find($id);

//         if (!$car) {
//             throw $this->createNotFoundException('La voiture demandée n\'existe pas.');
//         }

//         // Créer et gérer le formulaire d'édition
//         $form = $this->createForm(CarFilterType::class, $car);
//         $form->handleRequest($request);

//         if ($form->isSubmitted() && $form->isValid()) {
//             // Enregistrer les modifications
//             $carRepository->save($car, true);
//             // Rediriger vers la liste des voitures
//             return $this->redirectToRoute('car_index');
//         }

//         return $this->render('car/edit.html.twig', [
//             'form' => $form->createView(),
//             'car' => $car,
//         ]);
//     }

//     #[Route('/cars/{id}/delete', name: 'car_delete', methods: ['POST'])]
//     public function delete(int $id, CarRepository $carRepository)
//     {
//         $car = $carRepository->find($id);

//         if (!$car) {
//             throw $this->createNotFoundException('La voiture demandée n\'existe pas.');
//         }

//         // Supprimer la voiture
//         $carRepository->remove($car, true);

//         // Rediriger vers la liste des voitures après suppression
//         return $this->redirectToRoute('car_index');
//     }
// }




namespace App\Controller;

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
            $cars = $carRepository->filterCars($filters)->getQuery()->getResult();
        } else {
            // Récupérer les voitures filtrées
            $cars = $carRepository->filterCars($filters)->getQuery()->getResult();
        }

        return $this->render('car/index.html.twig', [
            'cars' => $cars,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/cars/{id}/edit', name: 'car_edit')]
    public function edit(int $id, Request $request, CarRepository $carRepository)
    {
        $car = $carRepository->find($id);

        if (!$car) {
            throw $this->createNotFoundException('La voiture demandée n\'existe pas.');
        }

        // Créer et gérer le formulaire d'édition
        $form = $this->createForm(CarFilterType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistrer les modifications
            $carRepository->save($car, true);
            // Rediriger vers la liste des voitures
            return $this->redirectToRoute('car_index');
        }

        return $this->render('car/edit.html.twig', [
            'form' => $form->createView(),
            'car' => $car,
        ]);
    }

    #[Route('/cars/{id}/delete', name: 'car_delete', methods: ['POST'])]
    public function delete(int $id, CarRepository $carRepository)
    {
        $car = $carRepository->find($id);

        if (!$car) {
            throw $this->createNotFoundException('La voiture demandée n\'existe pas.');
        }

        // Supprimer la voiture
        $carRepository->remove($car, true);

        // Rediriger vers la liste des voitures après suppression
        return $this->redirectToRoute('car_index');
    }
}

