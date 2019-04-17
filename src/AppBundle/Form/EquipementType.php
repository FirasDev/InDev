<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EquipementType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reference',TextType::class,['required'=>false])
            ->add('libelle', TextType::class,['required'=>false])
            ->add('description', TextType::class,['required'=>false])
            ->add('prix', NumberType::class,['required'=>false])
            ->add('quantite',NumberType::class,['required'=>false])
            ->add('file',FileType::class,['required'=>false])
            ->add('categorie',ChoiceType::class,['choices'=>[
                'Randonnée'=>'Randonnée',
                'Ski'=>'Ski',
                'Natation'=>'Natation',
                'Escalade'=>'Escalade'
            ]])
            ->add('type',ChoiceType::class,[
                'choices'=>[
                    'Vente'=>'Vente',
                    'Echange'=>'Echange'
                ]
            ]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Equipement'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_equipement';
    }


}
