<?php
namespace App\Command;

use App\Repository\UserRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:list-users',
    description: 'Liste tous les utilisateurs'
)]
class ListUsersCommand extends Command
{
    public function __construct(private UserRepository $userRepository)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        
        $users = $this->userRepository->findAll();
        
        if (count($users) === 0) {
            $io->warning('Aucun utilisateur trouvé.');
            return Command::SUCCESS;
        }
        
        $io->table(
            ['ID', 'Email', 'Rôles', 'Nom', 'Prénom', 'Actif'],
            array_map(function($user) {
                return [
                    $user->getId(),
                    $user->getEmail(),
                    implode(', ', $user->getRoles()),
                    $user->getLastName() ?? 'N/A',
                    $user->getFirstName() ?? 'N/A',
                    $user->isActive() ? 'Oui' : 'Non'
                ];
            }, $users)
        );

        return Command::SUCCESS;
    }
}