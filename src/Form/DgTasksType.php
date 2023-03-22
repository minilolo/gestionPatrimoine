<?php

namespace App\Form;

use App\Entity\DgTasks;
use App\Entity\Client;
use App\Repository\ClientRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DgTasksType extends AbstractType
{

    private $clientRepository;
    public function __construct(EntityManagerInterface $entityManager, ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class)
            ->add('ad', CheckboxType::class,[
                'false_values' => [null, ''],
                'required' => false,
            ])
            ->add('prmp', CheckboxType::class,[
                'false_values' => [null, ''],
                'required' => false,
            ])
            ->add('daj', CheckboxType::class,[
                'false_values' => [null, ''],
                'required' => false,
            ])
            ->add('daf', CheckboxType::class,[
                'false_values' => [null, ''],
                'required' => false,
            ])
            ->add('snd', CheckboxType::class,[
                'false_values' => [null, ''],
                'required' => false,
            ])
            ->add('srha', CheckboxType::class,[
                'false_values' => [null, ''],
                'required' => false,
            ])
            ->add('scofi', CheckboxType::class,[
                'false_values' => [null, ''],
                'required' => false,
            ])
            ->add('sad', CheckboxType::class,[
                'false_values' => [null, ''],
                'required' => false,
            ])
            ->add('suiteADonner', CheckboxType::class,[
                'false_values' => [null, ''],
                'required' => false,
            ])
            ->add('enParlerAuTelephone', CheckboxType::class,[
                'false_values' => [null, ''],
                'required' => false,
            ])
            ->add('venirEnParler', CheckboxType::class,[
                'false_values' => [null, ''],
                'required' => false,
            ])
            ->add('prospectionDeCandidature', CheckboxType::class,[
                'false_values' => [null, ''],
                'required' => false,
            ])
            ->add('avis', CheckboxType::class,[
                'false_values' => [null, ''],
                'required' => false,
            ])
            ->add('garderEnInstance', CheckboxType::class,[
                'false_values' => [null, ''],
                'required' => false,
            ])
            ->add('enFaireUneNote', CheckboxType::class,[
                'false_values' => [null, ''],
                'required' => false,
            ])
            ->add('affichage', CheckboxType::class,[
                'false_values' => [null, ''],
                'required' => false,
            ])
            ->add('copieAMeRetourner', CheckboxType::class,[
                'false_values' => [null, ''],
                'required' => false,
            ])
            ->add('suivi', CheckboxType::class,[
                'false_values' => [null, ''],
                'required' => false,
            ])
            ->add('attribution', CheckboxType::class,[
                'false_values' => [null, ''],
                'required' => false,
            ])
            ->add('information', CheckboxType::class,[
                'false_values' => [null, ''],
                'required' => false,
            ])
            ->add('rappeler', CheckboxType::class,[
                'false_values' => [null, ''],
                'required' => false,
            ])
            ->add('rendreCompte', CheckboxType::class,[
                'false_values' => [null, ''],
                'required' => false,
            ])
            ->add('procedureASuivre', CheckboxType::class,[
                'false_values' => [null, ''],
                'required' => false,
            ])
            ->add('representer', CheckboxType::class,[
                'false_values' => [null, ''],
                'required' => false,
            ])
            ->add('etudeEtEnParler', CheckboxType::class,[
                'false_values' => [null, ''],
                'required' => false,
            ])
            ->add('classement', CheckboxType::class,[
                'false_values' => [null, ''],
                'required' => false,
            ])
            ->add('remettre', CheckboxType::class,[
                'false_values' => [null, ''],
                'required' => false,
            ])
            ->add('client', EntityType::class , [
                'class' => client::class,
                'choice_label' => 'nom',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DgTasks::class,
        ]);
    }
}
