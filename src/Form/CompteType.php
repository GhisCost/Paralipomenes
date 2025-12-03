<?php

namespace App\Form;

use App\Entity\Histoires;
use App\Entity\User;
use App\Repository\UserRepository;
use PhpParser\Node\Stmt\Label;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\HttpFoundation\Response;

class CompteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $email= $options['email'];
        $username= $options['username'];

        $builder
            ->add('email', EmailType::class,[
                'data'=>$email
            ])
            ->add('password',PasswordType::class,['data'=>''])
            ->add('Username',TextType::class, [
                'data'=>$username ?? ''
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'email'=> null,
            'username'=>null
        ]);
    }
}
