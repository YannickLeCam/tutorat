<?php

namespace App\Form;

use App\Entity\ParrainAppreciation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RapportParrainType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('appreciation', null, [
                'attr' => ['class' => 'form-control'],
                'required' => true, // Champ obligatoire
            ])
            ->add('humeur', ChoiceType::class, [
                'choices' => [
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                ],
                'expanded' => true, // Renders as radio buttons
                'multiple' => false,
                'data' => 3, // Pré-sélectionner la valeur 3
                'required' => true, // Champ obligatoire
                'attr' => ['class' => 'd-flex justify-content-center'], // Centre les radios
            ])
            ->add('travail', ChoiceType::class, [
                'choices' => [
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                ],
                'expanded' => true, // Renders as radio buttons
                'multiple' => false,
                'data' => 3, // Pré-sélectionner la valeur 3
                'required' => true, // Champ obligatoire
                'attr' => ['class' => 'd-flex justify-content-center'], // Centre les radios
            ])
            ->add('Valider', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ParrainAppreciation::class,
        ]);
    }
}
