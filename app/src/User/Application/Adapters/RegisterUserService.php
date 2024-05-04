<?php
namespace App\User\Application\Adapters;

use App\Shared\Infrastructure\SPI\User\Registration\IRegisterUserService;
use App\User\Application\DTO\IRegisterUserDto;
use App\User\Domain\IUserDomainRepository;
use App\User\Domain\UserDomain;
use App\User\Infrastructure\Dbal\Repository\IUserRepository;

class RegisterUserService implements IRegisterUserService
{
    private IUserDomainRepository $userDomainRepository;

    public function __construct(IUserDomainRepository $userDomainRepository)
    {
        $this->userDomainRepository = $userDomainRepository;
    }

    public function register(IRegisterUserDto $dto): int
    {
        $userDomain = new UserDomain();
        $userDomain->setEmail($dto->getEmail());
        $userDomain->setPassword($dto->getPassword());
        return $this->userDomainRepository->create($userDomain);
    }
}