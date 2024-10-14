<?php

namespace App\Form;

use App\Dto\ClientDto;
use App\Entity\Client;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ClientDtoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('surname', TextType::class, [
                'label' => 'Surnom', 
            ])
            ->add('telephone', TextType::class, [
                'label' => 'Téléphone',
            ])
            ->add('adresse', TextType::class, [
                'label' => 'Adresse', 
            ])
           
            ->add('submit', SubmitType::class, [
                'label' => 'Ajouter',
                'attr' => ['class' => 'bg-burgundy hover:bg-burgundy-dark text-white font-bold py-2 px-4 rounded']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
{
    $resolver->setDefaults([
        'data_class' => ClientDto::class,  // Doit pointer vers votre DTO
    ]);
}

}
