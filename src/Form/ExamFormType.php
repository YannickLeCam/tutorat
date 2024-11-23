<?php
// src/Form/ExamFormType.php
namespace App\Form;

use App\Form\Model\ExamFormModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExamFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('examName', TextType::class)
            ->add('date', DateType::class, [
                'widget' => 'single_text', // Utilise <input type="date">
                'format' => 'yyyy-MM-dd', // Assure que la date est formatée correctement
            ])
            ->add('file', FileType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ExamFormModel::class,
        ]);
    }
}
