<?php
namespace App\Form;

use App\Entity\Top;
use App\Entity\User;
use App\Entity\Parrain;
use App\Repository\TopRepository;
use App\Repository\ParrainRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use App\Repository\DirectionRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class NouvAccountType extends AbstractType
{
    private $topRepository;
    private $parrainRepository;
    private $directionRepository;

    public function __construct(TopRepository $topRepository, ParrainRepository $parrainRepository , DirectionRepository $directionRepository)
    {
        $this->topRepository = $topRepository;
        $this->parrainRepository = $parrainRepository;
        $this->directionRepository = $directionRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('Valider', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary']
            ]);
    
        // Ajouter le champ idRole dynamiquement en fonction du rôle sélectionné
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $form = $event->getForm();
            $data = $event->getData();
    
            $role = $data->getRoles()[0] ?? null;
    
            if ($role === 'ROLE_PARRAIN') {
                $form->add('idRole', ChoiceType::class, [
                    'choices' => $this->getParrains(),
                    'attr' => ['class' => 'form-select'],
                ]);
            } elseif ($role === 'ROLE_TOP') {
                $form->add('idRole', ChoiceType::class, [
                    'choices' => $this->getTops(),
                    'attr' => ['class' => 'form-select'],
                ]);
            }elseif($role === 'ROLE_DIRECTION'){
                $form->add('idRole' , ChoiceType::class , [
                    'choices'=>$this->getDirections(),
                    'attr' => ['class' => 'form-select'],
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

        // Méthode pour récupérer la direction
        private function getDirections(): array
        {
            $directions = $this->directionRepository->findAll();
    
            $choices = [];
            foreach ($directions as $direction) {
                $choices[$direction->getNom()] = $direction->getId(); // Remplacer getNom() et getId() par les méthodes appropriées
            }
    
            return $choices;
        }
}
