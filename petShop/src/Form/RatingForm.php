<?php

namespace App\Form;

use App\Entity\Rating;
use App\Form\Type\StarRatingType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;

class RatingForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('review', TextareaType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "Tell us what you think about the product!",
                    ]),
                ],
            ])
            ->add('stars', StarRatingType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "Please rate this product!",
                    ]),
                ],
                'label' => 'Stars',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Rating::class,
        ]);
    }
}