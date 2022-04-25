<?php

namespace App\Form;

use App\Form\DataTransformer\FullnameToAuteurTransformer;
use App\Repository\AuteurRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\RouterInterface;

class AuteurSelectTextType extends AbstractType
{
    /**
     * @var AuteurRepository
     */
    private $auteurRepository;
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * AuteurSelectTextType constructor.
     * @param AuteurRepository $auteurRepository
     * @param RouterInterface $router
     */
    public function __construct(AuteurRepository $auteurRepository, RouterInterface $router)
    {
        $this->auteurRepository = $auteurRepository;
        $this->router = $router;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new FullnameToAuteurTransformer(
            $this->auteurRepository,
            $options['finder_callback']
        ));
    }

    public function getParent()
    {
        return TextType::class;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'invalid_message' => 'Hmm, auteur not found!',
            'finder_callback' => function(AuteurRepository $auteurRepository, string $fullname) {
                return $auteurRepository->findOneByFullname($fullname);
            },
        ]);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $attr = $view->vars['attr'];
        $class = isset($attr['class']) ? $attr['class'].' ' : '';
        $class .= 'js-auteur-autocomplete';

        $attr['class'] = $class;
        $attr['data-autocomplete-url'] = $this->router->generate('api_admin_list_auteur');
        $view->vars['attr'] = $attr;
    }

}