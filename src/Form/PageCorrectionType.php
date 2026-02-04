<?php

namespace App\Form;

use App\Entity\Corrections;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PageCorrectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
               ->add('contenu', TextareaType::class, [
                'required' => false,
                 'mapped' => false,
           'attr' => [
               'class' => 'cacher', // Même principe que le form pour la redaction des chapitres
           ]
       ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Null,
        ]);
    }
}
