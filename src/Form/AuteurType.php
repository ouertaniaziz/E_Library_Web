<?php

namespace App\Form;

use App\Entity\Auteur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints as Assert;
use function Sodium\add;

class AuteurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomAuteur',  null,[
                'required' => true,
                'constraints' => [new Assert\NotBlank(), new Assert\NotNull()]
            ])
            ->add('prenomAuteur');

        $imageConstraints = [
            new Image([
                'maxSize' => '500k',
                'uploadNoFileErrorMessage' => 'image photo obligatoir'
            ])
        ];


        $builder->add('photoFile', FileType::class, [
            'mapped' => false,
            'required' => false,
            'constraints' => $imageConstraints
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Auteur::class,
        ]);
    }
}
