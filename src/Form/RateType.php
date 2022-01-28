<?php

namespace App\Form;
use App\Entity\Rate;
use App\Repository\EquipeRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class RateType extends AbstractType
{


    private $userRepository;
    public  function __construct(EquipeRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            ->add('nomequipe', ChoiceType::class, [

                'multiple' => false,
                'choices' =>

                $this->userRepository->createQueryBuilder('u')->select('u.nomEquipe  as nom')->getQuery()->getResult(),
                'choice_label' => function ($choice) {
                    return $choice;
                },
            ])


            ->add('rate', ChoiceType::class, array(
                'choices' => array(
                    '⭐⭐⭐⭐⭐' => '5',
                    '⭐⭐⭐⭐' => '4',
                    '⭐⭐⭐' => '3',
                    '⭐⭐' => '2',
                    '⭐' => '1',
                    
                )
            ))











        ;



    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Rate::class,
        ]);
    }
}
