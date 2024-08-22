<?php
namespace App\Form;

use App\Entity\Top;
use App\Entity\Parrain;
use App\Repository\TopRepository;
use App\Repository\ParrainRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\User;

class NouvAccountType extends AbstractType
{
    private $topRepository;
    private $parrainRepository;

    public function __construct(TopRepository $topRepository, ParrainRepository $parrainRepository)
    {
        $this->topRepository = $topRepository;
        $this->parrainRepository = $parrainRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('password')
            ->add('isVerified')
            ->add('Valider', SubmitType::class);
    
        // Ajouter le champ idRole dynamiquement en fonction du rôle sélectionné
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $form = $event->getForm();
            $data = $event->getData();
    
            $role = $data->getRoles()[0] ?? null;
    
            if ($role === 'ROLE_PARRAIN') {
                $form->add('idRole', ChoiceType::class, [
                    'choices' => $this->getParrains(),
                ]);
            } elseif ($role === 'ROLE_TOP') {
                $form->add('idRole', ChoiceType::class, [
                    'choices' => $this->getTops(),
                ]);
            }
            // Pas besoin d'ajouter idRole si le rôle est Admin
        });
        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            $data = $event->getData();
        
            // Vérifiez si le rôle est défini et si c'est une chaîne
            if (isset($data['roles']) && is_string($data['roles'])) {
                // Transforme la chaîne en tableau
                $data['roles'] = [$data['roles']];
            }
        
            // Mettez à jour les données de l'événement avec la nouvelle valeur
            $event->setData($data);
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

    // Méthode pour récupérer les parrains
    private function getParrains(): array
    {
        $parrains = $this->parrainRepository->findAll();

        $choices = [];
        foreach ($parrains as $parrain) {
            $choices[$parrain->getNom()] = $parrain->getId(); // Remplacer getNom() et getId() par les méthodes appropriées
        }

        return $choices;
    }

    // Méthode pour récupérer les tops
    private function getTops(): array
    {
        $tops = $this->topRepository->findAll();

        $choices = [];
        foreach ($tops as $top) {
            $choices[$top->getNom()] = $top->getId(); // Remplacer getNom() et getId() par les méthodes appropriées
        }

        return $choices;
    }
}
