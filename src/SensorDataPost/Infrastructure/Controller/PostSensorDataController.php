<?php

declare(strict_types=1);


namespace App\SensorDataPost\Infrastructure\Controller;

use App\SensorDataPost\Domain\Model\ReadingModel;
use App\Temperature\Infrastructure\DTO\TemperatureDTO;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\UnwrappingDenormalizer;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/temperature-sensor/post-data', name: 'temperature_sensor_post_data', methods: 'POST')]
class PostSensorDataController extends AbstractController
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(Request $request)
    {
        if ($jsonContent = $request->getContent()) {
            $readingModel   = $this->serializer->deserialize($jsonContent, ReadingModel::class,  JsonEncoder::FORMAT, [UnwrappingDenormalizer::UNWRAP_PATH => '[reading]']);
            $temperature    = (new TemperatureDTO)->createFromReadingModel($readingModel);
            $this->entityManager->persist($temperature);
            $this->entityManager->flush();
        };
    }
}