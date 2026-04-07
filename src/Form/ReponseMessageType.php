<?php

namespace App\Form;

use App\Entity\Messages;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReponseMessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('objet',TextType::class,[
                'label'=>"Objet du message :",
                ])
            ->add('contenu',TextareaType::class,[
                'label'=>"Expliquez ce qui vous convient ou non dans les corrections ci-dessous: ",
            ])
            ->add('enregistrer', SubmitType::class, [
                'label' => 'Envoie du message',
                'attr' => ['class' => ' btn eagle fond-rouge texte-beige'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Messages::class,
        ]);
    }
}
