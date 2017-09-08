<?php

namespace CMS\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use CMS\BlogBundle\Form\DataTransformer\ImageToNumberTransformer;
use Doctrine\Common\Persistence\ObjectManager;


class ArticleType extends AbstractType
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('metadescription')
            ->add('datepublication')
            ->add('datecreation')
            ->add('category',  EntityType::class, array('class' => 'CMSBlogBundle:Category',  'choice_label' => 'title',))
            //->add('thumb',  EntityType::class, array('class' => 'CMSBlogBundle:Image',  'choice_label' => 'alt', 'data_class' => null))
            ->add('thumb',  TextType::class, array('invalid_message'=> 'Id d\'image pas valide !'))
            //->add('thumb')
        ;

        $builder->get('thumb')->addModelTransformer( new ImageToNumberTransformer($this->manager));
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CMS\BlogBundle\Entity\Article'
        ));
    }
}
