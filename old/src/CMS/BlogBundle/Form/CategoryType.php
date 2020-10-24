<?php

namespace CMS\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class CategoryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('parent', EntityType::class, array(
                                                'class' => 'CMSBlogBundle:Category',
                                                'choice_label' => 'title',
                                                'required'    => false,
                                                'placeholder' => 'ajouter un parent',
                                                'empty_data'  => null,
                                                )
             )
            ->add('enfants', EntityType::class, array(
                                                'class' => 'CMSBlogBundle:Category',
                                                'choice_label' => 'title',
                                                'required'    => false,
                                                'placeholder' => 'ajouter un enfant',
                                                'empty_data'  => null,
                                                )
            )
            ->add('dossier')
            ->add('page', CheckboxType::class, array('required' => false))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CMS\BlogBundle\Entity\Category'
        ));
    }
}
