<?php

namespace App\Form;

use App\Entity\Proposition;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropositionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {   // la fonction add permet de créer les champs du fomulaire
        $builder
            ->add('titre')
            ->add('artiste')
            ->add('lien_spotify')

            // ->add('date')

            //->add('user')

        ;
        
    }

    public function configureOptions(OptionsResolver $resolver)//???
    {
        $resolver->setDefaults([
            'data_class' => Proposition::class,
        ]);
    }
}
