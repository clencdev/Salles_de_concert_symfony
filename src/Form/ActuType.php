<?php

namespace App\Form;

use App\Entity\Actu;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ActuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' =>"Titre de l'actu"
            ])
            ->add('text_content', TextareaType::class, [
                'label' => "Contenu"
            ])
            
            ->add('images', FileType::class, [
                'label'=>"Photo",

                'mapped'=>false,

                'required'=>false,

                'constraints'=> [
                    new File([
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                            'image/bmp',
                            'image/tiff',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image file',
                    ])
                ]



            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Actu::class,
        ]);
    }
}
