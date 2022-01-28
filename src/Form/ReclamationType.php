<?php

namespace App\Form;

use App\Entity\Reclamation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Repository\CoachRepository;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ReclamationType extends AbstractType
{

    private $userRepository;
    public  function __construct(CoachRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('idjoueur')
            
                ->add('nomprenomcoach', ChoiceType::class, [

                    'multiple' => false,
                    'choices' =>
    
                    $this->userRepository->createQueryBuilder('u')->select("CONCAT(u.nomCoach,' ',u.prenomCoach) as id")->getQuery()->getResult(),
                    'choice_label' => function ($choice) {
                        return $choice;
                    },
                ])
            
            ->add('sujetrec', ChoiceType::class, array(
                'choices' => array(
                    'Application' => 'Application',
                    'Coach' => 'Coach',
                    'Autre' => 'Autre',
                )
            ))




            ->add(
                'descriptionrec',
                TextareaType::class,
                array('attr' => array('rows' => '500', 'cols' => '120', 'style' => 'height:130px;resize:none'))

            )

            /**
 *           ->add('daterec', \Symfony\Component\Form\Extension\Core\Type\DateType::class, [
  *              'widget' => 'single_text',
   *             'required' => false,
    *            'empty_data' => '',
     *       ])
*/





            ->add('nomjoueur')
            ->add('prenomjoueur')
            ->add('emailjoueur')
            ->add('tljoueur')


            ->add('imgrec', FileType::class, array('data_class' => null,'required' => false),  [
                'label' => true,

            ])



            
            

            /**
     *          ->add('idjoueur')
     *       ->add('sujetrec')
     *       ->add('descriptionrec')
      *      ->add('statusrec')
     *       ->add('daterec')
     *       ->add('datetraitement')
    *        ->add('nomprenomcoach')
    *        ->add('nomjoueur')
    *        ->add('prenomjoueur')
    *        ->add('emailjoueur')
     *       ->add('tljoueur')
      *      ->add('imgrec')
       *     ->add('opened') 
     */
        ;

    
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);
    }
}
