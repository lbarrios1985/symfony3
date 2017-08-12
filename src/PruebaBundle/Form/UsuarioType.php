<?php

namespace PruebaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class UsuarioType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nombre',TextType::class,array("required"=>"required","attr"=>array("class"=>"form-nombre form-control")))
                ->add('persona',TextType::class,array("required"=>"required","attr"=>array("class"=>"form-persona form-control")))
                ->add('correo',EmailType::class,array("required"=>"required","attr"=>array("class"=>"form-correo form-control")))
                ->add('clave',PasswordType::class,array("required"=>"required","attr"=>array("class"=>"form-clave form-control")))
                ->add('Guardar',SubmitType::class,array("attr"=>array("class"=>"form-submit btn btn-success")));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PruebaBundle\Entity\Usuario'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'pruebabundle_usuario';
    }


}
