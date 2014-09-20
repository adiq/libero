<?php

namespace Adiq\LiberoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BookType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('year', null, array('years' => range(Date('Y'), 1800), 'label' => 'Rok wydania: '))
            ->add('title', null, array('label' => 'Tytuł: '))
            ->add('publisher', null, array('label' => 'Wydawca: '))
            ->add('authors', null, array('required' => false, 'label' => 'Autorzy: '))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Adiq\LiberoBundle\Entity\Book'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'adiq_liberobundle_book';
    }

}
