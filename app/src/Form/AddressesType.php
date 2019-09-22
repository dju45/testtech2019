<?php

namespace App\Form;

use App\Model\Entity\Addresses;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('number', NumberType::class,
                ['attr' => [
                    'min' => 1,
                    'max' => 4
                ]])
            ->add('street', TextType::class)
            ->add('postalCode', NumberType::class,
                ['attr' => [
                    'min' => 1,
                    'max' => 6
                ]])
            ->add('city', TextType::class)
            ->add('country', CountryType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Addresses::class,
        ]);
    }
}
