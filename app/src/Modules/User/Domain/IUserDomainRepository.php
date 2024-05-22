<?php
namespace App\Modules\User\Domain;

interface IUserDomainRepository
{
    public function create(UserDomain $userDomain): int;
}