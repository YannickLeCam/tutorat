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

class RechercheParrainType extends AbstractType
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
            ->add('top', EntityType::class, [
                'class' => Top::class,
                'choice_label' => 'id',
                'required' => false, // Le champ 'top' est facultatif
            ])
            ->add('faculte', EntityType::class, [
                'class' => Faculte::class,
                'choice_label' => 'id',
                'required' => false, // Le champ 'faculte' est facultatif
            ])
            ->add('Valider',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Parrain::class,
            'method' => 'GET', // Utilisation de la méthode GET pour la recherche
            'csrf_protection' => false, // Pas besoin de protection CSRF pour une recherche
        ]);
    }
}
