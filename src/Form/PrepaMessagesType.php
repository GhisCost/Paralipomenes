<?php

namespace App\Form;

use App\Entity\Messages;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PrepaMessagesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('objet',TextType::class,[
                'label'=>"Objet du message :",
                ])
            ->add('contenu',TextareaType::class,[
                'label'=>"Informer l'auteur de vos corrections: ",
            ])
            ->add('enregistrer', SubmitType::class, [
                'label' => 'Envoie du message',
                'attr' => ['class' => 'btn btn-primary eagle fond-rouge texte-beige'],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Messages::class,
        ]);
    }
}
