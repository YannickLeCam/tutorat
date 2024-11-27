<?php

namespace App\Form;

use App\Entity\Filleul;
use App\Entity\NoteEtudiant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class NouvNoteEtudiantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('date', null, [
                'widget' => 'single_text',
            ])
            ->add('note')
            ->add('total_points')
            ->add('rang',)
            ->add('filleul', EntityType::class, [
                'class' => Filleul::class,
                'choice_label' => 'nom',
                'attr' => ['class' => 'form-select'],
            ])
            ->add('Valider', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary']
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NoteEtudiant::class,
        ]);
    }
}
