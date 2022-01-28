<?php

namespace App\Form;

use App\Entity\Coach;
use App\Entity\Equipe;
use App\Repository\CoachRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class EquipeType extends AbstractType
{
    private $userRepository;
    public  function __construct(CoachRepository $userRepository)
    {
        $this->userRepository=$userRepository;

    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomEquipe')
          ->add('idCoach', EntityType::class, [
              // looks for choices from this entity
              'class' => Coach::class,

              // uses the User.username property as the visible option string
              'choice_label' => 'nomCoach',

              // used to render a select box, check boxes or radios
              // 'multiple' => true,
              // 'expanded' => true,
          ]);;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Equipe::class,
        ]);
    }
}
