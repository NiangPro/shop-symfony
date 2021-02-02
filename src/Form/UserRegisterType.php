<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserRegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => ['placeholder' => 'Entrez le nom de l\'employé']])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
                'attr' => ['placeholder' => 'Entrez le prénom de l\'employé']])
            ->add('phone', TelType::class, [
                'label' => 'N° de telephone',
                'attr' => ['placeholder' => 'Entrez le numéro de telephone de l\'employé']])
            ->add('adresse', TextType::class, [
                'attr' => ['placeholder' => 'Entrez l\'adresse de l\'employé']])
            ->add('email', EmailType::class, [
                'label'=>'Adresse email',
                'attr' => ['placeholder' => 'Entrez l\'adresse email']])
            ->add('username', TextType::class, [
                'label' => 'login',
                'attr' => ['placeholder' => 'Entrez le login de l\'employé']])
            ->add('password', PasswordType::class, [
                'label'=>'Mot de passe',
                'attr' => ['placeholder' => 'Entrez le mot de passe']])
            ->add('passwordConfirm', PasswordType::class, [
                'label'=>'Mot de passe de confirmation',
                'attr' => ['placeholder' => 'Entrez le mot de passe de confirmation']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
