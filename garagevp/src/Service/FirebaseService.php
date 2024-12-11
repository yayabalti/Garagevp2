<?php

namespace App\Service;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Database;

class FirebaseService
{
    private $database;

    public function __construct()
    {
        // Configurez Firebase ici
        $firebase = (new Factory)->withServiceAccount(__DIR__.'/path/to/firebase_credentials.json');
        $this->database = $firebase->createDatabase();
    }

    public function saveAvis(array $data)
    {
        // Enregistrer l'avis dans Firebase sous un noeud "avis"
        $this->database->getReference('avis')->push($data);
    }
}
