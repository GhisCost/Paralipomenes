<?php

namespace App\Form;

use App\Entity\Histoires;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TitreHistoireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Titre de l\'histoire:',
                'attr' => ['class' => 'lavish texte-rouge fond-beige'],
            ])
            ->add('enregistrer', SubmitType::class, [
                'label' => 'Modifier le titre',
                'attr' => ['class' => 'btn btn-primary eagle fond-rouge texte-beige'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Histoires::class,
        ]);
    }
}