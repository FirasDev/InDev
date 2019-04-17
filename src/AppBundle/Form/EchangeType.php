<?php

namespace AppBundle\Form;

use AppBundle\Entity\Equipement;
use AppBundle\Repository\EquipementRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EchangeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('demande', TextareaType::class,['required'=>false])
            ->add('equipement1', EntityType::class,['class'=>Equipement::class,
                'query_builder' => function (EquipementRepository $er) use ($options) {
                    return $er->createQueryBuilder('u')
                        ->where('u.idUser = :id_user')
                        ->andWhere('u.quantite > 0')
                        ->setParameter('id_user',$options['current_user']);
                }
            ])
            ->add('equipement2', EntityType::class, ['class'=>Equipement::class]);
    }


    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Echange'
        ));
        $resolver->setRequired(array(
            'current_user'
        ));
        $resolver->setRequired('current_user'); // Requires that currentOrg be set by the caller.
        $resolver->setAllowedTypes('current_user', 'integer');
    }



    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_echange';
    }




}
