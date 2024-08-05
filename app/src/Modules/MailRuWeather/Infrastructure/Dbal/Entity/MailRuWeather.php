<?php

namespace App\Modules\MailRuWeather\Infrastructure\Dbal\Entity;

use App\Modules\MailRuWeather\Infrastructure\Dbal\Repository\MailRuWeatherRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;

#[ORM\Entity(repositoryClass: MailRuWeatherRepository::class)]
class MailRuWeather
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[Column(type: "datetime", nullable: false)]
    private DateTime $datetime;

    //@todo возможно переделать по integer занчения
    #[ORM\Column(type: 'string', nullable: false)]
    private string $temp;

    //@todo возможно переделать по integer занчения
    #[ORM\Column(type: 'string', nullable: false)]
    private string $temp_sense;

    #[ORM\Column(type: 'integer', nullable: false)]
    private int $rain_chance;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatetime(): DateTime
    {
        return $this->datetime;
    }

    public function setDatetime(DateTime $datetime): self
    {
        $this->datetime = $datetime;

        return $this;
    }

    public function getTemp(): string
    {
        return $this->temp;
    }

    public function setTemp(string $temp): self
    {
        $this->temp = $temp;

        return $this;
    }

    public function getTempSense(): string
    {
        return $this->temp_sense;
    }

    public function setTempSense(string $tempSense): self
    {
        $this->temp_sense = $tempSense;

        return $this;
    }

    public function getRainChance(): int
    {
        return $this->rain_chance;
    }

    public function setRainChance(int $rainChance): self
    {
        $this->rain_chance = $rainChance;

        return $this;
    }
}