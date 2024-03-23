<?php

namespace App\Form;

use App\Entity\Media;
use App\Entity\Picture;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class PictureFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre de la photo',
                'label_attr' => [
                    'class' => 'pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] 
                    truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out 
                    peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary-900 
                    peer-data-[te-input-state-active]:-translate-y-[0.9rem] 
                    peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 
                    dark:peer-focus:text-primary',
                    'for' => "exampleFormControlInput1"
                ],
                'attr' => ['class' => "peer block min-h-[auto] w-full rounded border-2 bg-transparent px-3 py-[0.32rem] 
                leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 
                data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none 
                dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0",
                    'id' => "exampleFormControlInput1",
                    'placeholder' => 'Titre de la photo']
            ])
            ->add('alt', TextType::class, [
                'label' => 'Texte alternatif de l\'image',
                'label_attr' => [
                    'class' => 'pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] 
                    truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out 
                    peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary-600 
                    peer-data-[te-input-state-active]:-translate-y-[0.9rem] 
                    peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 
                    dark:peer-focus:text-primary',
                    'for' => "exampleFormControlInput2"
                ],
                'attr' => [
                    'class' => 'peer block min-h-[auto] w-full rounded border-2 bg-transparent px-3 py-[0.32rem] 
                    leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 
                    data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none 
                    dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0',
                    'id' => "exampleFormControlInput2",
                    'placeholder' => ''
                ]
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => "peer block min-h-[auto] w-full rounded border-2 bg-transparent px-3 py-[0.32rem] 
                    leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 
                    data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none 
                    dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0",
                    'id' => "exampleFormControlInput3",
                    'placeholder' => ''
                ],
                'label' => 'Description de la photo',
                'label_attr' => [
                    'class' => 'pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] 
                    truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out 
                    peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary-600 
                    peer-data-[te-input-state-active]:-translate-y-[0.9rem] 
                    peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 
                    dark:peer-focus:text-primary',
                    'for' => "exampleFormControlInput3"
                ]
            ])
            ->add('pictureFile', FileType::class, [
                'attr' => [
                    'class' => "peer block min-h-[auto] w-full rounded border-2 bg-transparent px-3 py-[0.32rem] 
                    leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 
                    data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none 
                    dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0",
                    'id' => "exampleFormControlInput4",
                    'placeholder' => ''
                ],
                'label' => 'image à télécharger',
                'label_attr' => [
                    'class' => "mb-2 inline-block text-neutral-700 dark:text-neutral-200",
                    'for' => "exampleFormControlInput4"
                ],
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'image/*'
                        ],
                        'mimeTypesMessage' => 'The mime type of the file is invalid ({{ type }}). Allowed mime types are {{ types }}.'
                    ])
                ]
            ])
            ->add('Medias', EntityType::class, [
                'attr' => [
                    'class' => "peer block min-h-[auto] w-full rounded border-2 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0",
                    'id' => "exampleFormControlInput4",
                ],
                'class' => Media::class,
                'choice_label' => 'name',
                'expanded' => 'true',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Picture::class,
        ]);
    }
}
