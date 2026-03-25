<?php

namespace App\Controller\Admin;

use App\Entity\Histoires;
use App\Enum\StatutHistoire;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;

class HistoiresCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Histoires::class;
    }

  
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('titre'),
            DateField::new('datePublication'),
            ChoiceField::new('statut')
                ->setChoices([
                    'En cours de redaction' => StatutHistoire::ENCOURS,
                    'En correction' => StatutHistoire::CORRECTION,
                    'Publié'=> StatutHistoire::PUBLIER
                ])
                ->renderAsBadges(),
                AssociationField::new('user')
                    ->hideOnForm(),
                ];
            
    }

}
