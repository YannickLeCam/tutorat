<?php

namespace App\Form;

use App\Entity\Faculte;
use App\Entity\Filleul;
use App\Entity\Mineure;
use App\Entity\Parrain;
use App\Entity\Specialite;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RechercheFilleulFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', null, [
                'required' => false, // Le champ 'nom' est facultatif
                'attr' => ['class' => 'form-control'],
            ])
            ->add('prenom', null, [
                'required' => false, // Le champ 'prenom' est facultatif
                'attr' => ['class' => 'form-control'],
            ])
            ->add('mail', null, [
                'required' => false, // Le champ 'mail' est facultatif
                'attr' => ['class' => 'form-control'],
            ])
            ->add('telephone', null, [
                'required' => false, // Le champ 'telephone' est facultatif
                'attr' => ['class' => 'form-control'],
            ])
            ->add('mineure', EntityType::class, [
                'class' => Mineure::class,
                'choice_label' => 'name',
                'required' => false, // Le champ 'mineure' est facultatif
                'attr' => ['class' => 'form-select'],
            ])
            ->add('specialite', EntityType::class, [
                'class' => Specialite::class,
                'choice_label' => 'name',
                'required' => false, // Le champ 'specialite' est facultatif
                'attr' => ['class' => 'form-select'],
            ])
            ->add('parrain', EntityType::class, [
                'class' => Parrain::class,
                'choice_label' => 'nom',
                'required' => false, // Le champ 'parrain' est facultatif
                'attr' => ['class' => 'form-select'],
            ])
            ->add('faculte', EntityType::class, [
                'class' => Faculte::class,
                'choice_label' => 'name',
                'required' => false, // Le champ 'faculte' est facultatif
                'attr' => ['class' => 'form-select'],
            ])
            ->add('Rechercher', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Filleul::class,
            'method' => 'GET', // Utilisation de la méthode GET pour la recherche
            'csrf_protection' => false, // Pas besoin de protection CSRF pour une recherche
        ]);
    }
}
