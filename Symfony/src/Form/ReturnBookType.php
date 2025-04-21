<?php

namespace App\Form;

use App\Entity\Loan;
use App\Entity\ReturnBook;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReturnBookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('returnDate', null, [
                'widget' => 'single_text'
            ])
            ->add('loan', EntityType::class, [
                'class' => Loan::class,
'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ReturnBook::class,
        ]);
    }
}
