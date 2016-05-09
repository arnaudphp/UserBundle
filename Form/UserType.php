<?php
/** Namespaces */
namespace Leoo\UserBundle\Form;

/** Usages*/
use FOS\UserBundle\Form\Type\RegistrationFormType;
use Leoo\UserBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;


/**
 * Class UserType
 * @package Leoo\UserBundle\Form
 */
class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('roles', ChoiceType::class, array(
            'choices'  => [
                User::ROLE_DEFAULT => 'user',
                User::ROLE_ADMIN => 'admin',
            ],
            'required' => true,
            'multiple' => true,
        ));
    }

    public function getParent()
    {
        return RegistrationFormType::class;
    }

    public function getName()
    {
        return null;
    }


}
