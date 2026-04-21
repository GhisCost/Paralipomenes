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
                'attr' => [
                'class' => 'cacher', // on cache le textarea "normal", Quill va faire le boulot à la place
                ]
                ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Corrections::class, 
        ]);
    }
}