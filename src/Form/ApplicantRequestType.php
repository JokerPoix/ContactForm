<?php

namespace App\Form;

use App\Entity\ApplicantRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

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
            ->add('question')
            ->add('additionnalInformations');
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ApplicantRequest::class,
        ]);
    }
}
