<?php

namespace App\Form;

use App\Entity\Bien;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BienType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('surface')
            ->add('nbrepieces')
            ->add('nbrechambres')
            ->add('adresse')
            ->add('ville')
            ->add('codepostale')
            ->add('vendu')
            ->add('created_at')
            ->add('updated_at')
            ->add('energie')
            ->add('prix')
            ->add('imagefile')
            ->add('descriptions')
            // ajouter un champs image au formulaire:
            ->add('image', FileType::class, [
                'label' => false,
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Bien::class,
        ]);
    }
}
