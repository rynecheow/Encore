<?php

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\BaseType;

class UserProfileType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('firstName', 'text')
            ->add('lastName', 'text')
            ->add('birthDate', 'text')
            ->add('contactNo', 'email')
            ->add('address');
    }

    public function getName()
    {
        return 'user_profile';
    }
}