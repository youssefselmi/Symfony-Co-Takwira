<?php

namespace App\Form;

use App\Entity\Entrainement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Repository\CoachRepository;
use App\Repository\StadeRepository;
use Captcha\Bundle\CaptchaBundle\Form\Type\CaptchaType;
use Captcha\Bundle\CaptchaBundle\Validator\Constraints\ValidCaptcha;



class Entrainement2Type extends AbstractType
{
    private $CoachRepository;
    private $StadeRepository;
    public  function __construct(CoachRepository $CoachRepository,StadeRepository $StadeRepository)
    {
        $this->CoachRepository = $CoachRepository;
        $this->StadeRepository = $StadeRepository;
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('duree')
            ->add('dateEntrainement', DateType::class, [
                // renders it as a single text box
                'widget' => 'single_text',
            ])


            ->add('heure', ChoiceType::class, array(
                'choices' => array(
                    '9' => '9',
                    '10' => '10',
                    '11' => '11',
                    '12' => '12',
                    '13' => '13',
                    '14' => '14',
                    '15' => '15',
                    '16' => '16',
                    '17' => '17',
                    '18' => '18',
                    '19' => '19',
                    '20' => '20',
                    '21' => '21',
                    '22' => '22',
                    '23' => '23',

                )
            ))


            ->add('idCoach', ChoiceType::class, [

                'multiple' => false,
                'choices' =>

                    $this->CoachRepository->createQueryBuilder('u')->select("(u.idCoach) as id")->getQuery()->getResult(),
                'choice_label' => function ($choice) {
                    return $choice;
                },
            ])


            ->add('idStade', ChoiceType::class, [

                'multiple' => false,
                'choices' =>

                    $this->StadeRepository->createQueryBuilder('u')->select("(u.idStade) as id")->getQuery()->getResult(),
                'choice_label' => function ($choice) {
                    return $choice;
                },
            ])




            ->add('idEquipe')
            ->add('type', ChoiceType::class, array(
                'choices' => array(
                    'Attaque' => 'Attaque',
                    'Diffence' => 'Diffence',
                    'Milieu' => 'Milieu',
                )
            ))














        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Entrainement::class,
        ]);
    }
}
