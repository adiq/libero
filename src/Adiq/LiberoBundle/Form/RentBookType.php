<?php

namespace Adiq\LiberoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class RentBookType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reader', null, array('label' => 'Czytelnik: '))
            ->add('book', 'entity', [
                'label' => 'Książka: ',
                'class' => 'AdiqLiberoBundle:Book',
                'query_builder' => function(EntityRepository $er) {

                    return $er->createQueryBuilder('b')
                        ->orderBy('b.title', 'ASC')
                        ->where('b.isRented = False');
                }
                ])
            ->add('out_date', 'datetime', array('label' => 'Data wypożyczenia książki: '))
            ->add('due_date', 'datetime', array('label' => 'Termin zwrotu książki: '))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Adiq\LiberoBundle\Entity\Action'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'adiq_liberobundle_rentbook';
    }
}
