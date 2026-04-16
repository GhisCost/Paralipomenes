<?php

namespace App\Controller\Admin;

use App\Entity\Messages;
use App\Form\PieceJointeType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;

class MessagesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Messages::class;
    }

 public function configureFields(string $pageName): iterable
{
    return [
        TextEditorField::new('contenu', 'Contenu'),
        DateTimeField::new('dateEnvoi', 'Date d\'envoi'),
        AssociationField::new('destinataire', 'Destinataire')
            ->setRequired(true),
        AssociationField::new('expediteur', 'Expéditeur')
            ->setRequired(true),
        BooleanField::new('envoyer', 'Envoyé'),
        TextField::new('objet', 'Objet'),
        BooleanField::new('AffichageExpe', 'Affichage Expéditeur'),
        BooleanField::new('AffichageDesti', 'Affichage Destinataire'),
        CollectionField::new('pieceJointes', 'Pièces jointes')
            ->setEntryType(PieceJointeType::class)
            ->allowAdd()
            ->allowDelete()
            ->onlyOnForms(),
    ];
}
}



