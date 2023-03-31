<?php

namespace App\Form;

use App\Entity\Movie;
use phpDocumentor\Reflection\PseudoTypes\Numeric_;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class MovieFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title',TextType::class,[
                'attr'  => [
                    'class' =>'form',
                ],
                'label'=> 'Titre du film',
                'constraints' => [
                    new NotBlank([
                        "message" =>"Champs obligatoire"
                    ]),
                    new Length([
                        'min'=>3,
                        'max'=>20,
                        'minMessage'=>"Minimum {{ limit }}  caractéres" ,
                        'maxMessage'=>"Maximum {{ limit }} caractéres",
                    ])
                ]
            ])
            ->add('Author',TextType::class,[
                'attr'  => [
                    'class' =>'form',
                ],
                'label'=> 'Réalisateur ',
                'constraints' => [
                    new NotBlank([
                        "message" =>"Champs obligatoire"
                    ]),
                    new Length([
                        'min'=>3,
                        'max'=>20,
                        'minMessage'=>"Minimum {{ limit }}  caractéres" ,
                        'maxMessage'=>"Maximum {{ limit }} caractéres",
                    ])
                ]
            ])
            ->add('description', TextareaType::class,[
                'attr'  => [
                    'class' =>'form',
                ],
                'label'=> 'Synopsis',
                'constraints' => [
                    new NotBlank([
                        "message" =>"Champs obligatoire"
                    ]),
                    new Length([
                        'min'=>10,
                        'max'=>200,
                        'minMessage'=>"Minimum {{ limit }}  caractéres" ,
                        'maxMessage'=>"Maximum {{ limit }} caractéres",
                    ])
                ]
            ])
            ->add('image',FileType::class,[
                'mapped' => false,
                'attr'  => [
                    'class' =>'form',
                ],
                'label'=> 'Affiche',
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
            ->add('product_year',NumberType::class,[
                'attr'  => [
                    'class' =>'form',
                ],
                'label'=> 'Date de sortie',
                'constraints' => [
                    new NotBlank([
                        "message" =>"Champs obligatoire"
                    ]),
                    new Length([
                        'min'=>3,
                        'max'=>5,
                        'minMessage'=>"Minimum {{ limit }}  caractéres" ,
                        'maxMessage'=>"Maximum {{ limit }} caractéres",
                    ])
                ]
            ])
            ->add('category',TextType::class,[
                'attr'  => [
                    'class' =>'form',
                ],
                'label'=> 'Catégorie',
                'constraints' => [
                    new NotBlank([
                        "message" =>"Champs obligatoire"
                    ]),
                    new Length([
                        'min'=>3,
                        'max'=>20,
                        'minMessage'=>"Minimum {{ limit }}  caractéres" ,
                        'maxMessage'=>"Maximum {{ limit }} caractéres",
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Movie::class,
        ]);
    }
}
