<?php

namespace App\Form\DataTransformer;

use App\Entity\Auteur;
use App\Repository\AuteurRepository;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class FullnameToAuteurTransformer implements DataTransformerInterface
{
    /**
     * @var AuteurRepository
     */
    private AuteurRepository $auteurRepository;
    /**
     * @var callable
     */
    private $finderCallback;

    /**
     * NameToUserTransformer constructor.
     * @param AuteurRepository $auteurRepository
     * @param callable $finderCallback
     */
    public function __construct(AuteurRepository $auteurRepository, callable $finderCallback)
    {
        $this->auteurRepository = $auteurRepository;
        $this->finderCallback = $finderCallback;
    }

    public function transform($value)
    {
        if (null === $value){
            return '';
        }
        if(!$value instanceof  Auteur){
            throw new \LogicException('The AuteurSelectTextType can only be used with Auteur objects');
        }
        return $value->getFullName();
    }

    public function reverseTransform($value)
    {
        if(!$value){
            return '';
        }
        $callback = $this->finderCallback;
        $auteur = $callback($this->auteurRepository, $value);
        //  $user = $this->userRepository->findOneBy(['email' => $value]);
        if(!$auteur){
            throw new TransformationFailedException(sprintf(
                'No auteur found with fullname "%s"',
                $value
            ));
        }
        return $auteur;
    }
}