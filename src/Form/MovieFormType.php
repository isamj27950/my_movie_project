<?php

namespace App\Form;

use App\Entity\Movie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class MovieFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('Author')
            ->add('description')
            ->add('image',FileType::class,[
                'mapped' => false,
                'attr'  => [
                    'class' =>'form',
                ],
                'label'=> 'Image du post',
                'constraints'=> [
                    //new NotBlank([
                     //   "message" =>"Champs obligatoire"
                   // ]),
                    new File([
                        'maxSize' => '3M',
                        'maxSizeMessage' =>'Votre fichier ne doit dépasser {{ limit }} ',
                        'mimeTypes' => [
                            'image/jpeg', 'image/avif', 'image/png'
                        ],
                        'mimeTypesMessage' =>'Votre fichier doit être de type {{ types }} ',
                    ])
                ]
            ] )
            ->add('product_year')
            ->add('category')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Movie::class,
        ]);
    }
}
