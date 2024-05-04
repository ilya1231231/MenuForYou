<?php
namespace App\Shared\Infrastructure\SPI\User\Login;

interface ILoginUserReader
{
    public function readJson(string $raw);

}