<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array('label' => 'Titre'))
            ->add('subtitle', TextType::class, array('label' => 'Sous-titre'))
            ->add('background', TextType::class, array('label' => 'Arrière-plan (URL)'))
            ->add('date', DateTimeType::class, array('label' => 'Date'))
            ->add('content', TextareaType::class, array('label' => 'Contenu'))
            ->add('author', EntityType::class, array('class' => 'AppBundle:User',
                                                     'choice_label' => 'username',
                                                     'label' => 'Auteur'))
            ->add('categories', EntityType::class, array('class' => 'AppBundle:Category',
                                                         'choice_label' => 'name',
                                                         'label' => 'Catégories',
                                                         'multiple' => true))
            ->add('save', SubmitType::class, array('label' => 'Sauvegarder'));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
                                   'data_class' => 'AppBundle\Entity\Article'
                               ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_article';
    }
}
