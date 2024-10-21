<?php

namespace App\Form;

use App\Dto\ClientSearchDto;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
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
            'required' => false,
            'empty_data'=>'',
            'attr' =>[
                'placeholder' =>'774799479',
                'id'=>'telephone',
            ],
            'constraints'=>[
                new Regex(
                    '/^(77|78|76)([0-9]{7})$/',
                    'le numero doit etre de form  77-XXX-XX-XX /78 /76 ',
                )]
        ])
        ->add('surname', TextType::class, [
            'required' => false,
            'empty_data'=>'',
            'attr' =>[
                'placeholder' =>'Surname',
                'id'=>'surname',
            ],
            'constraints'=>[  
                new NotNull([
                    'message'=>'le surname ne peut pas etre vide.',
                ]),  
            ]
        ])

        ->add('rechercher', SubmitType::class, [
            'label' => 'Search',
            'attr' => ['class' => 'bg-burgundy ml-2 text-white text-sm px-3 rounded h-10 hover:bg-red-700']
        ])       
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
           'data_class' => ClientSearchDto::class,
        ]);
    }
}
