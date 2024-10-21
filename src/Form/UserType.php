<?php

namespace App\Form;

use App\Entity\User;
use App\Enums\UserRole;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prenom' ,TextType::class, [
                'label' => 'Prenom',
                'required' => false,
                'attr' => [
                    'id' => 'prenomUser',  
                ],
                'constraints' => [
                new NotNull([ 
                    'message'=>'le prenom ne peut pas etre vide .',
                ]),
            ]])
            ->add('nom',TextType::class, [
                'label' => 'Nom',
                'required' => false,
                'attr' => [
                    'id' => 'nomUser',  
                ],
                'constraints' => [
                    new NotNull([ 
                        'message'=>'le nom ne peut pas etre vide .',
                    ]),
                ]])
          
            ->add('login',TextType::class, [
                'label' => 'Login',
                'required' => false,
                'attr' => [
                    'id' => 'loginUser',  
                ],
                'constraints' => [
                    new NotNull([ 
                        'message'=>'le login ne peut pas etre vide .',
                    ]),
                ]])
            ->add('password',TextType::class, [
                'label' => 'Password',
                'required' => false,
                'attr' => [
                    'id' => 'mdp',  
                ]
            , 'constraints' => [
                new NotNull([ 
                    'message'=>'le mot de pass ne peut pas etre vide .',
                ]),
            ]])
            ->add('role', ChoiceType::class, [
                'choices' => [
                    'Boutiquier' => UserRole::roleBoutiquier,
                    'Client' => UserRole::roleClient,
                ],
                'placeholder' => 'Choisissez un rôle',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le rôle est obligatoire.',
                    ])
                ],
                'choice_label' => function($choice, $key, $value) {
                    return $key;
                }
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
