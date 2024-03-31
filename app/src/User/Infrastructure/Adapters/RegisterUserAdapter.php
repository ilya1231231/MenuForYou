<?php
namespace App\User\Infrastructure\Adapters;

use App\User\Application\Ports\IRegisterUserPort;
use App\User\Infrastructure\Dbal\Entity\User;
use App\User\Infrastructure\Dbal\Repository\IUserRepository;

class RegisterUserAdapter implements IRegisterUserPort
{
    private IUserRepository $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(User $user): int
    {
        return $this->userRepository->create($user);
    }
}