<?php

namespace App\Form;

use App\Dto\ClientDto;
use App\Entity\Client;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\NotBlank;
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
                    'class' => 'text-sm p-2 border rounded w-full',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le nom est obligatoire.',
                    ]),
                ],
            ])
            ->add('telephone', TextType::class, [
                'label' => 'Telephone',
                'required' => false, 
                'attr' => [
                    'id' => 'telephone',
                    'class' => 'text-sm p-2 border rounded w-full',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le numéro de téléphone est obligatoire.',
                    ]),
                    new Regex([
                        'pattern' => '/^(77|78|76|70)[0-9]{7}$/',
                        'message' => 'Veuillez entrer un numéro de téléphone valide  77-XXXX-XXX /70 /78 /76.',
                    ]),
                ],
            ])
            ->add('adresse', TextareaType::class, [
                'required' => false,
                'label' => 'Adresse',
                'attr' => [
                    'id' => 'adresse',
                    'class' => 'text-sm p-2 border rounded w-full',
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Ajouter',
                'attr' => ['class' => 'bg-burgundy hover:bg-burgundy-dark text-white font-bold py-2 px-4 rounded']
            ]);
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
