<?php

namespace BlogBundle\Form;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ajouterBlogForm extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titreBlog',null,array('attr' => array('class' => 'ckeditor')))
            ->add('articleBlog',CKEditorType::class)
            ->add('afficheFile', VichImageType::class,['label'=> false,'required'=>false])
           // ->add('dateAjoutBlog')
          //  ->add('nombreVuBlog')
            //->add('idUtilisateur')
            ->add('Ajouter',SubmitType::class, ['label' => 'Ajouter']);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Blog'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_blog';
    }


}
