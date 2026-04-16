<?php

namespace App\Controller\Admin;

use App\Entity\Corrections;
use App\Form\PieceJointeType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;

class CorrectionsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Corrections::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('user', 'Utilisateur'),
            AssociationField::new('Chapitres', 'Chapitre'),
            TextEditorField::new('Contenu', 'Contenu de la correction'),
            AssociationField::new('Histoire', 'Histoire'),
            ChoiceField::new('statut', 'Statut')
                ->setChoices(\App\Enum\StatutCorrection::cases())
                ->renderAsBadges(),
             CollectionField::new('pieceJointes', 'Pièces jointes')
            ->setEntryType(PieceJointeType::class)
            ->allowAdd()
            ->allowDelete()
            ->onlyOnForms(),
            IntegerField::new('numeroChapitre', 'Numéro de chapitre'),
        ];
    }
}

