<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class KidType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => false,
                'label' => 'name',
                'translation_domain' => 'messages',
            ])
            ->add('sex', ChoiceType::class, [
                'label' => 'sex',
                'translation_domain' => 'messages',
                'choices' => ['None' => null, 'Male' => 'male', 'Female' => 'female'],
                'required' => true,
            ])
            ->add('dateOfBirth', DateType::class, [
                'label' => 'dateOfBirth',
                'translation_domain' => 'messages',
                'html5' => false,
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'attr' => [
                    'class' => 'js-datepicker',
                    'data-provide' => 'datepicker',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
        ]);
    }
}
