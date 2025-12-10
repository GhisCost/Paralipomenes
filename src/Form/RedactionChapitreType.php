<?php

namespace App\Form;

use App\Entity\Chapitres;
use App\Entity\Corrections;
use App\Entity\Histoires;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RedactionChapitreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('contenu', TextareaType::class, [
           'attr' => [
               'class' => 'cacher', // on cache le textarea, Quill va prendre le relais
           ]
       ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Chapitres::class,
        ]);
    }
}
