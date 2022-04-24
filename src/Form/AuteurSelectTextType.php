<?php

namespace App\Form;

use App\Repository\AuteurRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class AuteurSelectTextType extends AbstractType
{
    private $userRepository;
    public function __construct(AuteurRepository $auteurRepository)
    {
        $this->userRepository = $auteurRepository;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new EmailToAuteurTransformer($this->userRepository));
    }


    public function getParent()
    {
        return TextType::class;
    }


}