<?php

namespace Adiq\LiberoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ReaderType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array('label' => 'Imię: '))
            ->add('lastname', null, array('label' => 'Nazwisko: '))
            ->add('address', null, array('label' => 'Adres: '))
            ->add('pesel', null, array('label' => 'Numer PESEL:'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Adiq\LiberoBundle\Entity\Reader'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'adiq_liberobundle_reader';
    }
}
