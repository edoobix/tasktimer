<?php

namespace App\Form;

use App\Entity\Department;
use App\Entity\User;
use App\Enum\UserPositionEnum;
use App\Enum\UserRoleEnum;
use App\Form\DataTransformer\RolesToEnumTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'login',
                TextType::class,
                [
                    'label' => 'Логин',
                    'required' => true,
                ]
            )
            ->add(
                'number',
                IntegerType::class,
                [
                    'label' => 'Номер пользователя',
                    'required' => false,
                ]
            )
            ->add(
                'roles',
                EnumType::class,
                [
                    'label' => 'Роли пользователя',
                    'required' => false,
                    'class' => UserRoleEnum::class,
                    'multiple' => true,
                    'expanded' => true,
                    'choice_label' => fn (UserRoleEnum $choice) => $choice->getLabel(),
                ]
            )
            ->add(
                'password',
                PasswordType::class,
                [
                    'mapped' => false,
                    'label' => 'Пароль',
                    'help' => 'Оставьте пустым чтобы не изменять',
                    'required' => false,
                ]
            )
            ->add(
                'position',
                EnumType::class,
                [
                    'label' => 'Должность',
                    'placeholder' => 'Выберите должность',
                    'class' => UserPositionEnum::class,
                    'required' => true,
                    'multiple' => false,
                    'expanded' => false,
                    'choice_label' => fn (UserPositionEnum $choice) => $choice->getLabel(),
                ]
            )
            ->add('departments', EntityType::class, [
                'class' => Department::class,
                'label' => 'Отделы',
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => false,
                'required' => false,
                'query_builder' => function (\Doctrine\ORM\EntityRepository $er) {
                    return $er->createQueryBuilder('d')
                        ->orderBy('d.name', 'ASC');
                },
                'attr' => [
                    'class' => 'select2',
                ],
            ])
        ;

        $builder->get('roles')->addModelTransformer(new RolesToEnumTransformer());
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
