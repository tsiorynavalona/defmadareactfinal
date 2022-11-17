<?php

namespace App\Form;

use App\Entity\Doleance;



use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
//use Symfony\Component\Form\Extension\Core\Type\ReCaptchaType;

class DoleanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('subject', TextType::class, ['label'=>'Sujet'])
            ->add('description', TextareaType::class, ['label'=>'Description'])
            ->add('email', EmailType::class, ['label'=>'Email'])
            ->add('phone', TelType::class, ['label'=>'Votre téléphone'])
            ->add('isPublished', HiddenType::class, ['label'=>'publiée', 'empty_data' => false])
            ->add('save', SubmitType::class, ['label'=>'Envoyer'])
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Doleance::class,
        ]);
    }
}
