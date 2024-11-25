<?php
// src/Form/ExamFormType.php
namespace App\Form;

use App\Entity\Faculte;
use App\Form\Model\ExamFormModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ExamFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('examName', TextType::class,[
                'attr' => ['class' => 'form-select']
            ])
            ->add('date', DateType::class, [
                'widget' => 'single_text', // Utilise <input type="date">
                'format' => 'yyyy-MM-dd', // Assure que la date est formatée correctement
                'attr' => ['class' => 'form-select']
            ])
            ->add('faculte', EntityType::class, [
                'class' => Faculte::class,
                'choice_label' => 'name',
                'attr' => ['class' => 'form-select']
            ])
            ->add('file', FileType::class);

        //add some form class custom
        $builder->setAttribute('attr', ['class' => 'custom-form-class']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ExamFormModel::class,
        ]);
    }
}
