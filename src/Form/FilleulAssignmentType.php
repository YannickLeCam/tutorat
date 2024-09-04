<?php

namespace App\Form;

use App\Entity\Mineure;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilleulAssignmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('filleuls', CollectionType::class, [
                'entry_type' => ChoiceType::class,
                'entry_options' => [
                    'choices' => $options['mineures_disponibles'],
                    'choice_label' => function (Mineure $mineure) {
                        return $mineure->getName();
                    },
                ],
                'allow_add' => false,
                'by_reference' => false,
                'label' => 'Réassigner à',
            ])
            ->add('valider', SubmitType::class, ['label' => 'Valider'])
            ->add('annuler', SubmitType::class, ['label' => 'Annuler']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'mineures_disponibles' => [],
        ]);
    }
}
