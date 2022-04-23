<?php

namespace App\Form;

use App\Entity\Users;
use App\Entity\Role;
use Symfony\Component\Form\AbstractType;
use App\Repository\RoleRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;


class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomUser')
            ->add('prenomUser')
            ->add('emailUser')

            ->add('mdpUser', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options'  => ['label' => ' '],
                'second_options' => ['label' => ' '],
            ])
            ->add('telUser')
            ->add('adresse')




        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
