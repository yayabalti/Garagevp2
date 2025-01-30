<?php

namespace App\Tests\Controller;

use App\Entity\User;
use App\Kernel;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UserControllerTest extends WebTestCase
{
    private $client;
    private $entityManager;

    protected function setUp(): void
    {
        $this->client = self::createClient();
        $this->entityManager = $this->client->getContainer()
            ->get('doctrine')
            ->getManager();

        // Chargement de l'autoloader
        require_once __DIR__ . '/../vendor/autoload.php';
    }

    protected static function getKernelClass(): string
    {
        return Kernel::class;
    }

    // Test API Endpoints
    public function testGetUsers(): void
    {
        $this->client->request('GET', '/api/users');
        
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertJson($this->client->getResponse()->getContent());
    }

    public function testCreateUserSuccess(): void
    {
        $userData = [
            'email' => 'test_create@example.com',
            'password' => 'password123',
            'firstname' => 'John',
            'lastname' => 'Doe',
            'roles' => ['ROLE_USER']
        ];

        $this->client->request(
            'POST',
            '/api/users',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($userData)
        );

        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('id', $response);
    }

    public function testCreateUserWithMissingFields(): void
    {
        $userData = [
            'email' => 'incomplete@example.com'
            // password manquant
        ];

        $this->client->request(
            'POST',
            '/api/users',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($userData)
        );

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $this->client->getResponse()->getStatusCode());
    }

    public function testCreateDuplicateUser(): void
    {
        // Créer un premier utilisateur
        $user = new User();
        $user->setEmail('duplicate@example.com');
        $user->setPassword('password123');
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        // Tenter de créer un utilisateur avec le même email
        $userData = [
            'email' => 'duplicate@example.com',
            'password' => 'password123'
        ];

        $this->client->request(
            'POST',
            '/api/users',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($userData)
        );

        $this->assertEquals(Response::HTTP_CONFLICT, $this->client->getResponse()->getStatusCode());
    }

    // Test Web Routes
    public function testSuperAdminDashboardAccess(): void
    {
        // Créer un utilisateur super admin
        $userAdmin = new User();
        $userAdmin->setEmail('superadmin@example.com');
        $userAdmin->setPassword('password123');
        $userAdmin->setRoles(['ROLE_SUPER_ADMIN']);
        
        $this->entityManager->persist($userAdmin);
        $this->entityManager->flush();

        // Simuler la connexion
        $this->client->loginUser($userAdmin);

        $this->client->request('GET', '/admin/super');
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    public function testEmployeDashboardAccess(): void
    {
        // Créer un utilisateur employé
        $userEmploye = new User();
        $userEmploye->setEmail('employe@example.com');
        $userEmploye->setPassword('password123');
        $userEmploye->setRoles(['ROLE_ADMIN']);
        
        $this->entityManager->persist($userEmploye);
        $this->entityManager->flush();

        // Simuler la connexion
        $this->client->loginUser($userEmploye);

        $this->client->request('GET', '/admin/employe');
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }
}