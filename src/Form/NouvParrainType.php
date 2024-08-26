<?php

namespace App\Form;

use App\Entity\Top;
use App\Entity\Faculte;
use App\Entity\Parrain;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class NouvParrainType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('top', EntityType::class, [
                'class' => Top::class,
                'choice_label' => 'nom',
            ])
            ->add('faculte',EntityType::class,[
                'class'=> Faculte::class,
                'choice_label' => 'name',
            ])
            ->add('Valider',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Parrain::class,
        ]);
    }
}
