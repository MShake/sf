<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EditGroupForm extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
		->add('name', null, array('attr' => array(
				'placeholder' => 'Group name',
		)));
	}

	public function getName()
	{
		return 'editgroupform';
	}
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
				'data_class' => 'AppBundle\Entity\ChatGroup',
		));
	}

}
