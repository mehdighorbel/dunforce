<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrganizationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $organization = $options['organization'];

        //------------------------------------------------------------------

        $builder
            ->add('name', TextType::class, [
                'label' => "Name",
                'data' => $organization ? $organization['name'] : null,
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => "Description",
                'data' => $organization ? $organization['description'] : null,
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'organization' => null
        ]);
    }
}
