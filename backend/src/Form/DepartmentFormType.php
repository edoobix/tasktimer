<?php

namespace App\Form;

use App\Entity\Department;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DepartmentFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'label' => 'Название',
                    'required' => true,
                ]
            )
            ->add(
                'director',
                EntityType::class,
                [
                    'label' => 'Руководитель',
                    'placeholder' => 'Выберите руководителя',
                    'class' => User::class,
                    'choice_label' => 'login',
                    'required' => true,
                ]
            )
            ->add(
                'users',
                EntityType::class,
                [
                    'label' => 'Сотрудники',
                    'placeholder' => 'Добавьте сотрудников',
                    'required' => false,
                    'class' => User::class,
                    'choice_label' => 'login',
                    'multiple' => true,
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Department::class,
        ]);
    }
}
