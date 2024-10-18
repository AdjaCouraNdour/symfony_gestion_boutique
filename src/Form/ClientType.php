<?php

namespace App\Form;

use App\Dto\ClientDto;
use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Regex;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('surname', TextType::class, [
            'label' => 'Surname',
            'required' => false,
            'attr' => [
                'id' => 'surname',  
            ]
        ])
        ->add('telephone', TextType::class, [
            'label' => 'Telephone',
            'required' => false,
            'attr' => [
                'id' => 'telephone',  
            ]
        ])
        ->add('adresse', TextareaType::class, [
            'required' => false,
            'label' => 'Adresse',
            'attr' => [
                'id' => 'Adresse',  // Ajout de l'id
            ]
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
            'data_class' => Client::class,
        ]);
    }
}
