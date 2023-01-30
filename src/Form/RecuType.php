<?php

namespace App\Form;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\Recu;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('matricule', TextType::class)
            ->add('Compte', TextType::class)
            ->add('objet', TextType::class )
            ->add('moyen', TextType::class)
            ->add('montant_ariary', MoneyType::class)
            ->add('montant_lettre', TextType::class)
            
            ->add('clientNom', TextType::class, [
                'mapped' => false,
            ])
            ->add('clientPrenom', TextType::class, [
                'mapped' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recu::class,
        ]);
    }
}
