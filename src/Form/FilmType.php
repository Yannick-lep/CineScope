<?php

namespace App\Form;

use App\Entity\Film;
use App\Entity\Platforme;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilmType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'attr' => ['placeholder' => 'Ex: Inception']
            ])
            ->add('synopsis', TextareaType::class, [
                'label' => 'Synopsis',
                'required' => false,
                'attr' => ['rows' => 5, 'placeholder' => 'Résumé du film...']
            ])
            ->add('releaseYear', IntegerType::class, [
                'label' => 'Année de sortie',
                'attr' => ['placeholder' => 'Ex: 2010']
            ])
            ->add('platformes', EntityType::class, [
                'label' => 'Plateformes disponibles',
                'class' => Platforme::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Film::class,
        ]);
    }
}