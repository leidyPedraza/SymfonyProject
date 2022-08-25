<?php

namespace App\Form;

use App\Entity\Categoria;
use App\Entity\Ingredient;
use App\Entity\Tapa;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewTapaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', TextType::class,array('attr' => array('class' => 'form-control')))
            ->add('descripcion',CKEditorType::class,  array('attr' => array('class' => 'form-control')))
            ->add('categoria', EntityType::class, [
                'class' => Categoria::class])
            ->add('ingredientes', EntityType::class, [
                'class' => Ingredient::class,
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('foto',FileType::class, array('attr' => array('onchange' => 'onChange(event)')))
            ->add('fechaCreacion',DateType::class)
            ->add('top')
            ->add('Guardar',SubmitType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tapa::class,
        ]);
    }
}
