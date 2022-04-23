<?php

namespace App\Form;

use App\Entity\Auteur;
use App\Repository\AuteurRepository;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class EmailToAuteurTransformer implements DataTransformerInterface
{
    private $userRepository;
    public function __construct(AuteurRepository $auteurRepository)
    {
        $this->userRepository = $auteurRepository;
    }

    public function transform($value)
    {
        if(null === $value){
            return "";
        }
        if(!$value instanceof Auteur){
            throw new \LogicException('the AuteurSlectTextType doit etre utilisé avec des Auteur Object');
        }
        return $value->getEmail();
    }

    public function reverseTransform($value)
    {
        $auteur = $this->userRepository->findOneBy(['email' => $value]);
        if(!$auteur){
            throw new TransformationFailedException(sprintf(
                'pas d\'auteur avec id "%s"',
                $value
            ));
        }
        return $auteur;
    }


}