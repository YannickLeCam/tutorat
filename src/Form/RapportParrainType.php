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
