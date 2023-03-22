<?php

namespace App\Form;

use App\Entity\Entrer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntrerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nature', TextType::class)
            ->add('quantity', MoneyType::class, [
                'currency' => 'MGA',
                
            ])
            ->add('date', DateType::class)
            ->add('methode', TextType::class)
            ->add('clientBE', TextType::class, [
                'mapped' => false,
                'label' => "Client (optionnel)",
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Entrer::class,
        ]);
    }
}
