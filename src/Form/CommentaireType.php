<?php

namespace App\Form;

use App\Entity\Commentaire;
use App\Entity\Evenement;
use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CommentaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('commentaire')
            /* ->add('event',EntityType::class,[
                 'class'=>Evenement::class,
                 'choice_label'=>'nom'])
 */
            ->add('user',EntityType::class,[
                'class'=>Users::class,
                'choice_label'=>'emailUser'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commentaire::class,
        ]);
    }
}
