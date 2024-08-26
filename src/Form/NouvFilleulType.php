<?php
namespace App\Form;


use App\Entity\Faculte;
use App\Entity\Filleul;
use App\Entity\Mineure;
use App\Entity\Parrain;
use App\Entity\Specialite;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class NouvFilleulType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('mail', EmailType::class)
            ->add('telephone', TextType::class)
            ->add('mineure', EntityType::class, [
                'class' => Mineure::class,
                'choice_label' => 'name',
            ])
            ->add('specialite', EntityType::class, [
                'class' => Specialite::class,
                'choice_label' => 'name',
            ])
            ->add('faculte', EntityType::class, [
                'class' => Faculte::class,
                'choice_label' => 'name',
            ])
            ->add('parrain', EntityType::class, [
                'class' => Parrain::class,
                'choice_label' => 'nom',
                'query_builder' => function (EntityRepository $er) use ($options) {
                    if ($options['edit_mode']) {
                        $top = $options['top'];
                        return $er->createQueryBuilder('p')
                            ->where('p.top = :top')
                            ->setParameter('top', $top);
                    } else {
                        return $er->createQueryBuilder('p');
                    }
                },
            ])
            ->add('Valider', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Filleul::class,
            'edit_mode' => false, // Par défaut, on est en mode création
            'top' => null, // Par défaut, aucun TOP n'est passé
        ]);
    }
}
