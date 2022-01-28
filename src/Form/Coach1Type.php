<?php

namespace App\Form;

use App\Entity\Coach;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Captcha\Bundle\CaptchaBundle\Form\Type\CaptchaType;
use Captcha\Bundle\CaptchaBundle\Validator\Constraints\ValidCaptcha;

class Coach1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomCoach')
            ->add('prenomCoach')
            ->add('dateNaissance', DateType::class, [
                // renders it as a single text box
                'widget' => 'single_text',
            ])

            ->add('grade', ChoiceType::class, array(
                'choices' => array(
                    'b0' => 'b0',
                    'b1' => 'b1',
                    'b2' => 'b2',
                    'b3' => 'b3',

                )
            ))

            ->add('dateFinContrat', DateType::class, [
                // renders it as a single text box
                'widget' => 'single_text',
            ])

            ->add('adresseMail')
            ->add('salaire')
            ->add('nbTropheLocaux')
            ->add('nbTropheInternationaux')

            ->add('formationPrefere', ChoiceType::class, array(
                'choices' => array(
                    '442 offensif' => '442 offensif',
                    '442 deffensif' => '442 deffensif',
                    '433 offensif' => '433 offensif',
                    '433 deffensif' => '433 deffensif',

                )
            ))


            ->add('imageFormation',  FileType::class, array('data_class' => null,'required' => false ),  [
                'label' => true,

            ])
                ->add('imageCoach', FileType::class,array('data_class' => null,'required' => false), ['label' => true,] )
            ->add('age')
            ->add('mdpCoach')






           ->add('captchaCode', CaptchaType::class, [
                'captchaConfig' => 'ExampleCaptchaUserRegistration',
                'constraints' => [
                    new ValidCaptcha([
                        'message' => 'Invalid captcha, please try again',
                    ])
                ]
            ])







        ;
    }



    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Coach::class,
        ]);
    }
}
