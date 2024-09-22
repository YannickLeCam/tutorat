<?php

namespace App\Form;

use App\Entity\Top;
use App\Entity\Filleul;
use App\Entity\TopAppreciation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RapportTopType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('appreciation', TextareaType::class, [
                'attr' => ['class' => 'form-control', 'rows' => 4],
                'required' => true, // Champ obligatoire
            ])
            ->add('Valider', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TopAppreciation::class,
        ]);
    }
}
