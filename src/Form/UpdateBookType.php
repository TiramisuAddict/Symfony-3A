<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Reader;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class UpdateBookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('publicationDate',DateType::class)

            ->add('published',CheckBoxType::class,[
                'required' => false,
            ])
            
            ->add('category', ChoiceType::class, [
                'label' => 'Category',
                'choices' => [
                    'Science-Fiction' => 'Science-Fiction',
                    'Mystery' => 'Mystery',
                    'Autobiography ' => 'Autobiography ',
                ],
                'placeholder' => 'Choose a category',
            ])

            ->add('authorBooks', EntityType::class, [
                'class' => Author::class,
                'choice_label' => 'id',
            ])
            
            ->add('Submit',SubmitType::class)

            /*
            ->add('bookReaders', EntityType::class, [
                'class' => Reader::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
