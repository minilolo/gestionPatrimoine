<?php

namespace App\Form;

use App\Entity\Courrier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class CourrierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('nature', TextType::class)
           
            
            
            
            ->add('courrierFile', FileType::class, [
                'label' => 'PDF File',
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PDF document',
                    ]),
                ],
            ])
            ->add('clientNom', TextType::class, [
                'mapped' => false,
            ])
            ->add('clientPrenom', TextType::class, [
                'mapped' => false,
            ])
            ->add('status', ChoiceType::class, [
                'mapped' => false,
                'choices' => [
                    'DAJ' => '2',
                    'COMPTA' => '3',
                    'DAM' => '1',
                    
                ],
                'label' => 'Direction à mettre joindre : '
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Courrier::class,
        ]);
    }
}
