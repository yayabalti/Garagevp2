<?php

namespace App\Controller;

use Kreait\Firebase\Factory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MessageController extends AbstractController
{
    private $firestore;

    // Injecter le service de Firestore
    public function __construct()
    {
        // Initialisation de Firebase Firestore
        $this->firestore = (new Factory)
            ->withServiceAccount(getenv('FIREBASE_CREDENTIALS_PATH'))  // Utilisation du chemin d'accès aux credentials
            ->createFirestore()
            ->database();
    }

    /**
     * @Route("/contact", name="app_contact")
     */
    public function contactForm()
    {
        return $this->render('contact.html.twig');
    }

    /**
     * @Route("/send-message", name="app_send_message", methods={"POST"})
     */
    public function sendMessage(Request $request)
    {
        // Récupérer les données du formulaire
        $nom = $request->request->get('nom');
        $prenom = $request->request->get('prenom');
        $email = $request->request->get('email');
        $objet = $request->request->get('objet');
        $message = $request->request->get('message');

        if (!$nom || !$prenom || !$email || !$objet || !$message) {
            $this->addFlash('error', 'Tous les champs sont requis.');
            return $this->redirectToRoute('app_contact');
        }

        // Ajouter le message à Firebase
        $data = [
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'objet' => $objet,
            'message' => $message,
            'createdAt' => time(),  // Timestamp du message
        ];

        // Essayer d'enregistrer le message dans la collection "messages" de Firebase
        try {
            $this->firestore->collection('messages')->add($data);
            $this->addFlash('success', 'Votre message a été envoyé avec succès!');
        } catch (\Exception $e) {
            // Si l'envoi échoue, afficher un message d'erreur
            $this->addFlash('error', 'Erreur lors de l\'envoi du message: ' . $e->getMessage());
            return $this->render('contact.html.twig'); // Garder l'utilisateur sur la même page
        }

        // Si l'envoi réussit, rediriger vers la page de contact avec un message de succès
        return $this->redirectToRoute('app_contact');
    }
}







