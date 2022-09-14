<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, ['attr' => ['class' => 'form-control']])
            // ->add('slug')
            ->add('image', FileType::class, ['required'=>false, 'data_class' => null, ], ['attr' => ['class' => 'form-control p-3']])
            ->add('contenu', CKEditorType::class, ['attr' => ['class' => 'form-control']])
            // ->add('created_at')
            // ->add('active')
            ->add('categorie', EntityType::class, ['class' => Categorie::class])
            ->add('Valider', SubmitType::class, ['attr' => ['class' => 'btn btn-primary mt-3']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
