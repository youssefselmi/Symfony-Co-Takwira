<?php

namespace App\Form;

use App\Entity\Equipe;
use App\Entity\Joueur;
use App\Repository\EquipeRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
class JoueurType extends AbstractType
{
    private $userRepository;
    public  function __construct(EquipeRepository $userRepository)
    {
        $this->userRepository=$userRepository;

    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomJoueur')
            ->add('prenomJoueur')
       /* ->add('dateNaissance', DateType::class, [
        // renders it as a single text box
        'widget' => 'single_text',
    ])*/

            ->add('ageJoueur')
            ->add('numero')
            ->add('adresseMail')
            ->add('ville')
           // ->add('categorie')

   /*  ->add('categorie', ChoiceType::class, [
    'choices'  => [
        'junior' => 'junior',
        'sunior' => 'sunior',

    ],
])*/

            ->add('position', ChoiceType::class, [
                'choices'  => [
                    'attaque' => 'attaque',
                    'deffense' =>  'deffense',
                    'milieu' => 'milieu' ,
                    'goal' =>  'goal',

                ],
            ])
          //  ->add('idEquipe')
          ->add('idEquipe', EntityType::class, [
              // looks for choices from this entity
              'class' => Equipe::class,

              // uses the User.username property as the visible option string
              'choice_label' => 'nomEquipe',

              // used to render a select box, check boxes or radios
              // 'multiple' => true,
              // 'expanded' => true,
          ])
            ->add('image', FileType::class,array('data_class' => null,'required' => false), ['label' => true,] )
            ->add('password')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Joueur::class,
        ]);
    }
}
