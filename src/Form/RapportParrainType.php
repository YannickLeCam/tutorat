<?php

namespace App\Form;

use App\Entity\Filleul;
use App\Entity\Parrain;
use App\Entity\ParrainAppreciation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RapportParrainType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('appreciation')
            ->add('humeur')
            ->add('travail')
            ->add('dateCreation', null, [
                'widget' => 'single_text',
            ])
            ->add('filleul', EntityType::class, [
                'class' => Filleul::class,
                'choice_label' => 'nom',
            ])
            ->add('parrain', EntityType::class, [
                'class' => Parrain::class,
                'choice_label' => 'nom',
            ])
            ->add('Valider',SubmitType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ParrainAppreciation::class,
        ]);
    }
}
