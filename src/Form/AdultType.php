<?php

namespace App\Form;

use App\Entity\Adult;
use App\Repository\KidRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdultType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var KidRepository $kidRepository */
        $kidRepository = $options['kidRepository'];

        $builder
            ->add('name', TextType::class, [
                'label' => 'name',
            ])
            ->add('surname', TextType::class, [
                'label' => 'surname',
                'translation_domain' => 'messages',
            ])
            ->add('kid', ChoiceType::class, [
                'choices' => $kidRepository->findAll(),
                'label' => 'kid',
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Adult::class,
        ]);

        $resolver->setRequired([
            'kidRepository',
        ]);
    }
}
