<?php

namespace App\Form;

use App\Entity\Ouverage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OuverageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomLivre')
            ->add('genreLivre')
            ->add('nbrEmprunt')
            ->add('nbrVente')
            ->add('prixVente')
            ->add('prixEmprunt')
            ->add('imgLivre')
            ->add('idCommande')
            ->add('auteur')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ouverage::class,
        ]);
    }
}
