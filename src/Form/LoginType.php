<?php

namespace App\Form;

use App\Entity\Users;
use App\Entity\Role;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('emailUser')
            ->add('mdpUser',PasswordType::class)







        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,

        ]);
          $resolver->setDefaults([
              'attr' => [
                  'novalidate' => 'novalidate', // comment me to reactivate the html5 validation!  🚥
              ]
          ]);
    }
}
