<?php

namespace App\Form;

use App\Entity\Achat;
use App\Entity\Product;
use Doctrine\Common\Collections\Expr\Value;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AchatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('produit', EntityType::class, [
                'class' => Product::class,
                'choice_label' => 'designation',
                'multiple' => true,
                'label' => false

            ])
            ->add('prix', NumberType::class, [
                'label' => false,
                'attr' => [
                    'value' => 0
                ]
            ])
            ->add('quantite', NumberType::class, [
                'label' => false,
                'attr' => [
                    'value' => 0
                ]
            ])
            ->add('montant', NumberType::class, [
                'label' => false,
                'attr' => [
                    'value' => $builder->getData()->getPrix() * $builder->getData()->getQuantite()
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Achat::class,
        ]);
    }
}
