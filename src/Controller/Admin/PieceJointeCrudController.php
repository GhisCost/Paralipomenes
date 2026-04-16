<?php

namespace App\Controller\Admin;

use App\Entity\PieceJointe;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class PieceJointeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PieceJointe::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('message', 'Message')
                ->setRequired(true),
            AssociationField::new('Correction', 'Correction')
                ->setRequired(true),
        ];
    }
}




