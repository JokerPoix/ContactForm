<?php

namespace App\Form;

use App\Entity\ApplicantRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class ApplicantRequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => "Raison de la demande",
            ])
            ->add('name', TextType::class, [
                'label' => "Nom",
            ])
            ->add('applicant', ApplicantType::class)
            ->add('question' , TextareaType::class ,[
                'attr' => ['class' => 'tinymce'],
            ])
            ->add('additionnalInformations' , TextareaType::class,[
                'attr' => ['class' => 'tinymce'],
            ]);;
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ApplicantRequest::class,
        ]);
    }
}
