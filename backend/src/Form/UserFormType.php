<?php

namespace App\Form;

use App\Entity\User;
use App\Enum\UserRoleEnum;
use App\Form\DataTransformer\RolesToEnumTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
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
