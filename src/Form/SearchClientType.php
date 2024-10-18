<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Regex;

class SearchClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('telephone', TextType::class, [
            'label' => 'Telephone', 
            'required' => false,
            'attr' =>[
                'placeholder' =>'774799479',
                // 'pattern' => '^([77|78|76])[0-9]{7}$',
                // 'class'=>'text-danger',
            ],
            'constraints'=>[
                
                new NotBlank([
                    'message'=>'renseigner un telephone valide.',
                ]),
                new Regex(
                    '/^(77|78|76)([0-9]{7})$/',
                    'le numero doit etre de form  77-XXX-XX-XX /78 /76 ',
                ),
            ]
        ]) 
        ->add('rechercher', SubmitType::class, [
            'label' => 'Search',
            'attr' => ['class' => 'bg-burgundy text-white text-sm px-3 rounded-r-md h-10 hover:bg-red-700']
        ])       
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
