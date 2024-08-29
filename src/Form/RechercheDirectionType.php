<?php

namespace App\Form;

use App\Entity\Faculte;
use App\Entity\Direction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RechercheDirectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', null, [
                'required' => false, // Le champ 'nom' est facultatif
            ])
            ->add('prenom', null, [
                'required' => false, // Le champ 'prenom' est facultatif
            ])
            ->add('faculte', EntityType::class, [
                'class' => Faculte::class,
                'choice_label' => 'name', // Utiliser le nom de la faculté comme label
                'required' => false, // Le champ 'faculte' est facultatif
            ])
            ->add('Rechercher', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Direction::class,
            'method' => 'GET', // Utilisation de la méthode GET pour la recherche
            'csrf_protection' => false, // Pas besoin de protection CSRF pour une recherche
        ]);
    }
}
