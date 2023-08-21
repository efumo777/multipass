<?php

namespace App\Temperature\Domain\Entity;

use ApiPlatform\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\GetCollection;
use App\Shared\State\MiddleTemperatureAllSensorProvider;
use App\Temperature\Domain\Repository\TemperatureRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TemperatureRepository::class)]
#[GetCollection(
    uriTemplate: '/get-average-temperature-in-range',
    normalizationContext: ['groups' => 'get-collection'],
    provider: MiddleTemperatureAllSensorProvider::class,
)]
class Temperature
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups('get-collection')]
    private ?float $temperatureCelsius = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sensorIp = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sensorUuid = null;

    #[ORM\Column]
    #[ApiFilter(RangeFilter::class)]
    #[Groups(['get-collection'])]
    private ?\DateTimeImmutable $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTemperatureCelsius(): ?float
    {
        return $this->temperatureCelsius;
    }

    public function setTemperatureCelsius(float $temperatureCelsius): static
    {
        $this->temperatureCelsius = $temperatureCelsius;

        return $this;
    }

    public function getSensorIp(): ?string
    {
        return $this->sensorIp;
    }

    public function setSensorIp(?string $sensorIp): static
    {
        $this->sensorIp = $sensorIp;

        return $this;
    }

    public function getSensorUuid(): ?string
    {
        return $this->sensorUuid;
    }

    public function setSensorUuid(?string $sensorUuid): static
    {
        $this->sensorUuid = $sensorUuid;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
