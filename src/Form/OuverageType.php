<?php

namespace App\Form;

use App\Entity\Auteur;
use App\Entity\Ouverage;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class OuverageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomLivre')
            ->add('genreLivre')
            ->add('prixVente')
            ->add('prixEmprunt');

        $imageConstraints = [
            new Image([
                'maxSize' => '500k',
                'uploadNoFileErrorMessage' => 'image ouverage obligatoir'
            ])
        ];
        $builder->add('ouverageImage', FileType::class, [
            'mapped' => false,
            'required' => false,
            'constraints' => $imageConstraints
        ])

            ->add('auteur', AuteurSelectTextType::class
                /*, [
                'class' => Auteur::class,
                'choice_label' => function (Auteur $auteur) {
                    return sprintf($auteur->getNomAuteur() . " " . $auteur->getPrenomAuteur());
                }
            ]*/
                );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ouverage::class,
        ]);
    }
}
