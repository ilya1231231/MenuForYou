<?php
namespace App\Modules\User\Application\Services;

use App\Modules\User\Domain\IUserDomainRepository;
use App\Modules\User\Domain\UserDomain;
use App\Modules\User\Infrastructure\API\IRegisterUserService;
use App\Modules\User\Application\DTO\RegisterUserDto;

class RegisterUserService implements IRegisterUserService
{
    private IUserDomainRepository $userDomainRepository;

    public function __construct(IUserDomainRepository $userDomainRepository)
    {
        $this->userDomainRepository = $userDomainRepository;
    }

    public function register(RegisterUserDto $dto): int
    {
        $userDomain = new UserDomain();
        $userDomain->setEmail($dto->getEmail());
        $userDomain->setPassword($dto->getPassword());
        return $this->userDomainRepository->create($userDomain);
    }
}