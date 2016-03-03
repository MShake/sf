<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AddGroupForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('name', null, array('attr' => array(
                    'placeholder' => 'Nom du groupe',
                )));
    }
    
    public function getName()
    {
        return 'addgroupform';
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {    
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\ChatGroup',
            ));
    }

}
