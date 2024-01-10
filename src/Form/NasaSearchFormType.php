<?php

namespace App\Form;

use App\Validator\DateNotInFuture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NasaSearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('start_date', DateType::class, [
                'attr' => [
                    'class' => "peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] 
                leading-[1.6]
                outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100
                peer-focus:text-primary data-[te-input-state-active]:placeholder:opacity-100
                motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200
                dark:peer-focus:text-primary [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0",
                    'placeholder' => "Select"
                ],
                'label' => 'Select the date',
                'label_attr' => [
                    'class' => 'pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem]
                leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem]
                peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem]
                peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200
                dark:peer-focus:text-primary',
                    'for' => 'floatingInput'
                ],
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd/MM/yyyy',
                'constraints' => [
                    new DateNotInFuture(),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}
