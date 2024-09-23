<?php

namespace App\Form;

use App\Entity\Top;
use App\Entity\Faculte;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class NouvTopType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
    $builder
    ->add('nom', TextType::class, [
        'attr' => ['class' => 'form-control']
    ])
    ->add('prenom', TextType::class, [
        'attr' => ['class' => 'form-control']
    ])
    ->add('faculte', EntityType::class, [
        'class' => Faculte::class,
        'choice_label' => 'name',
        'attr' => ['class' => 'form-select']
    ])
    ->add('Valider', SubmitType::class, [
        'attr' => ['class' => 'btn btn-primary']
    ]);
}

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Top::class,
        ]);
    }
}
