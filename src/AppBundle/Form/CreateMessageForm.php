<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CreateMessageForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('content', null, array('attr' => array(
                    'placeholder' => 'Taper votre message',
                )));
    }
    
    public function getName()
    {
        return 'createmessageform'; 
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {    
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Message',
            ));
    }

}
