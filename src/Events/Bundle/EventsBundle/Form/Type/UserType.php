<?php

namespace Events\Bundle\EventsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Events\Bundle\EventsBundle\Entity\User;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType {

    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        //First Name
        $builder->add('firstname', 'text', array(
            'attr' => array('class' => 'large_text'),
            'label' => 'First Name',
            'required' => true,
            'error_bubbling' => false
        ));        
        
        //Last Name
        $builder->add('lastname', 'text', array(
            'attr' => array('class' => 'large_text'),
            'label' => 'Family Name',
            'required' => true,
            'error_bubbling' => false
        ));        
             
        //Username
        $builder->add('username', 'text' , array(
            'label' => 'EPITA Login',
            'required' => true,
            'error_bubbling' => false,
        ));
        
        //Email Address
        $builder->add('email', 'email', array(
            'attr' => array('class' => 'large_text'),
            'label' => 'Email',
            'required' => true,
            'error_bubbling' => false,
        ));
        
        //Password
        $builder->add('plainPassword', 'repeated', array(
            'type' => 'password',
            'first_options' => array('label' => 'Password'),           
            'second_options' => array('label' => 'Confirm Password'),           
            'invalid_message' => 'plainPassword.not_match',
            'options' => array('attr' => array('class' => 'password-field')),
            'required' => true,
            'error_bubbling' => false,
        ));      
    
        
    }

    public function getDefaultOptions(array $options) {
        return array('csrf_protection' => FALSE);
    }

    public function getName() {
        return 'user';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Events\Bundle\EventsBundle\Entity\User',
            'validation_groups' => array('registration')
        ));
    }
}