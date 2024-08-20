<?php

namespace App\Form;

use App\Entity\Filleul;
use App\Entity\Mineure;
use App\Entity\Parrain;
use App\Entity\Specialite;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NouvFilleulType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('mail')
            ->add('telephone')
            ->add('mineure', EntityType::class, [
                'class' => Mineure::class,
                'choice_label' => 'id',
            ])
            ->add('specialite', EntityType::class, [
                'class' => Specialite::class,
                'choice_label' => 'id',
            ])
            ->add('parrain', EntityType::class, [
                'class' => Parrain::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Filleul::class,
        ]);
    }
}
