<?php

namespace App\Form;

use App\Enum\Sex;
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
                'label' => 'name',
                'required' => true,
            ])
            ->add('sex', ChoiceType::class, [
                'choices' => [
                    'male' => Sex::Male,
                    'female' => Sex::Female
                ],
                'label' => 'sex',
                'required' => true,
                'translation_domain' => 'messages',
            ])
            ->add('dateOfBirth', DateType::class, [
                'format' => 'yyyy-MM-dd',
                'label' => 'dateOfBirth',
                'required' => true,
                'translation_domain' => 'messages',
                'html5' => false,
                'widget' => 'single_text',
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
