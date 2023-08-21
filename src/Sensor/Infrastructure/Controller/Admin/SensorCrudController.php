<?php

declare(strict_types=1);

namespace App\Sensor\Infrastructure\Controller\Admin;

use App\Sensor\Domain\Entity\Sensor;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SensorCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Sensor::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('sensorIp'),
            BooleanField::new('isActive'),
            DateTimeField::new('createdAt')->onlyOnIndex(),
        ];
    }

}
