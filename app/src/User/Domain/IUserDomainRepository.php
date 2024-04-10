<?php
namespace App\User\Domain;

interface IUserDomainRepository
{
    public function create(UserDomain $userDomain): int;
}