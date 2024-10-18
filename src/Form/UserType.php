<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class, [
                'label' => 'Nom',
                'required' => false,
                'attr' => [
                    'id' => 'nomUser',  
                ]
            ])
            ->add('prenom' ,TextType::class, [
                'label' => 'Prenom',
                'required' => false,
                'attr' => [
                    'id' => 'prenomUser',  
                ]
            ])
            ->add('login',TextType::class, [
                'label' => 'Login',
                'required' => false,
                'attr' => [
                    'id' => 'loginUser',  
                ]
            ])
            ->add('password',TextType::class, [
                'label' => 'Password',
                'required' => false,
                'attr' => [
                    'id' => 'mdp',  
                ]
            ])
            ->add('role')

            ->add('client', EntityType::class, [
                'class' => Client::class,
                'choice_label' => 'id',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Ajouter',
                'attr' => ['class' => 'bg-burgundy hover:bg-burgundy-dark text-white font-bold py-2 px-4 rounded']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
