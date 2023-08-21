<?php

declare(strict_types=1);


namespace App\SensorDataGet\Application\MessageHandler;
use App\SensorDataGet\Application\Message\GetSingleSensorData;
use App\Temperature\Infrastructure\DTO\TemperatureDTO;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\HttpKernel\Log\Logger;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsMessageHandler]
class GetSingleSensorDataHandler implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    private const HTTP_SCHEMA = 'http://';
    private const REQUEST_URL = '/data';

    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(GetSingleSensorData $singleSensorData)
    {
        try {
            $sensorUrl  = self::HTTP_SCHEMA . $singleSensorData->getSensorIp() . self::REQUEST_URL;
            $response   = $this->httpClient->request(
                'GET',
                $sensorUrl,
            );
            $statusCode = $response->getStatusCode();
            if (200 === $statusCode) {
                $temperature = (new TemperatureDTO())->createFromCSVString($response->getContent());
                $temperature->setSensorIp($singleSensorData->getSensorIp());
                $this->entityManager->persist($temperature);
                $this->entityManager->flush();
            } else {
                throw new \Exception(sprintf('Error! Status code %s Temperature Sensor %s', $statusCode, $singleSensorData->getSensorIp()));
            }
        } catch (\Exception $exception) {
            //TODO need exception logging
            $this->logger->error(sprintf('Error! Temperature Sensor %s', $singleSensorData->getSensorIp()));
        }
    }
}