<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class SoporteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('asunto')
                ->add('descripcion')
                ->add('tipoSoporte', EntityType::class, array(
                    'class' => 'AppBundle:TipoSoporte',
                    'choice_label' => 'nombre',
                    'multiple' => false,
                    'placeholder' => 'Seleccione un tipo de soporte'));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Soporte',
            'attr' => ['id' => 'formRegistroSoporte']
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_soporte';
    }


}
