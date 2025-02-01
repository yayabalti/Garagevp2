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
   private static $testEmailCounter = 0;

   protected function setUp(): void
   {
       parent::setUp();
       $this->client = static::createClient();
       $this->entityManager = $this->client->getContainer()
           ->get('doctrine')
           ->getManager();

       // Nettoyer la base de données avant chaque test
       $connection = $this->entityManager->getConnection();
       $connection->executeStatement('TRUNCATE TABLE "users" RESTART IDENTITY CASCADE');
   }

   private function createAuthenticatedUser($roles = ['ROLE_USER'])
   {
       self::$testEmailCounter++;
       $email = sprintf('test%d@example.com', self::$testEmailCounter);

       $user = new User();
       $user->setEmail($email);
       $password = 'password123';
       
       $hasher = $this->client->getContainer()->get('security.password_hasher');
       $hashedPassword = $hasher->hashPassword($user, $password);
       
       $user->setPassword($hashedPassword);
       $user->setRoles($roles);
       $user->setFirstname('Test');
       $user->setLastname('User');

       $this->entityManager->persist($user);
       $this->entityManager->flush();

       $this->client->loginUser($user);

       return $user;
   }

   public function testGetUsers(): void
   {
       $this->createAuthenticatedUser(['ROLE_ADMIN']);
       
       $this->client->request(
           'GET', 
           '/api/users',
           [],
           [],
           [
               'HTTPS' => true,
               'HTTP_HOST' => 'localhost',
               'CONTENT_TYPE' => 'application/json',
               'HTTP_ACCEPT' => 'application/json'
           ]
       );

       $this->assertEquals(
           Response::HTTP_OK,
           $this->client->getResponse()->getStatusCode(),
           $this->client->getResponse()->getContent()
       );
   }

   public function testCreateUserSuccess(): void
   {
       $this->createAuthenticatedUser(['ROLE_ADMIN']);

       $userData = [
           'email' => 'new_user@example.com',
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
           [
               'HTTPS' => true,
               'HTTP_HOST' => 'localhost',
               'CONTENT_TYPE' => 'application/json',
               'HTTP_ACCEPT' => 'application/json'
           ],
           json_encode($userData)
       );

       $this->assertEquals(
           Response::HTTP_CREATED,
           $this->client->getResponse()->getStatusCode(),
           $this->client->getResponse()->getContent()
       );
   }

   public function testAdminDashboardAccess(): void
   {
       $this->createAuthenticatedUser(['ROLE_ADMIN']);
       
       $this->client->request(
           'GET', 
           '/admin',
           [],
           [],
           [
               'HTTPS' => true,
               'HTTP_HOST' => 'localhost'
           ]
       );
       
       $this->assertEquals(
           Response::HTTP_OK,
           $this->client->getResponse()->getStatusCode(),
           $this->client->getResponse()->getContent()
       );
   }

   public function testEmployeDashboardAccess(): void
   {
       $this->createAuthenticatedUser(['ROLE_EMPLOYE']);
       
       $this->client->request(
           'GET', 
           '/easyemploye/dashboard',  
           [],
           [],
           [
               'HTTPS' => true,
               'HTTP_HOST' => 'localhost'
           ]
       );
       
       $this->assertEquals(
           Response::HTTP_OK,
           $this->client->getResponse()->getStatusCode(),
           $this->client->getResponse()->getContent()
       );
   }

   protected function tearDown(): void
   {
       parent::tearDown();
       
       if ($this->entityManager) {
           $connection = $this->entityManager->getConnection();
           $connection->executeStatement('TRUNCATE TABLE "users" RESTART IDENTITY CASCADE');
           
           $this->entityManager->close();
           $this->entityManager = null;
       }
       
       $this->client = null;
   }
}