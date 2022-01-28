<?php

namespace App\Form;

use App\Entity\Equipe;
use App\Entity\Matchs;
use App\Entity\Stade;
use App\Entity\User;
use phpDocumentor\Reflection\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MatchsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      $builder
           ->add('idStade',EntityType::class,[
                'class'=>Stade::class,
                'choice_label'=>'nomStade',
                'multiple'=>false,
                'expanded'=>false
            ])
            ->add('idEquipe1',EntityType::class,[
                'class'=>Equipe::class,
                'choice_label'=>'nomEquipe',
                'multiple'=>false,
                'expanded'=>false
            ])
            ->add('idEquipe2',EntityType::class,[
                'class'=>Equipe::class,
                'choice_label'=>'nomEquipe',
                'multiple'=>false,
                'expanded'=>false
            ])
       /*  ->add('date',DateType::class,
         [ 'widget' => 'choice']
         )*/
       ->add('date', DateType::class, [
           'attr' => ['class' => 'js-datepicker'],
           'html5' => false,
       ])

          // ->add('date')
            ->add('heureDeb')
            ->add('heureFin')
            ->add('description')
            ->add('status',ChoiceType::class,[
                'choices' => [
                    'Termine' => 'Termine',
                    'En Programme' => 'En Programme',
                    'En Cours' => 'En Cours'
                ]
            ])
           /* ->add('score',ChoiceType::class,[
                'choices' => [
                    '0-0' => '0-0'
                    ]
            ])*/
          ->add('score', null, [
              'required'   => false,
              'empty_data' => '0-0',
          ])

            ->add('nbSpectateur')
            ->add('IdOrg',EntityType::class,[
                'class'=>User::class,
                'choice_label'=>'id',
                'multiple'=>false,
                'expanded'=>false
            ])
            //->add('Ajouter',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Matchs::class,
        ]);
    }
}
