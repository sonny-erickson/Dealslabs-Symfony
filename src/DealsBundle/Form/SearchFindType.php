<?php

namespace DealsBundle\Form;

use DealsBundle\Entity\Categorie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchFindType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('categorie', EntityType::class,[
                'class' => Categorie::class,
                'placeholder' => 'categorie.libelle',
                'label' => false,
                'expanded' => false,
                'multiple' => false,
                "required" => false,
                'attr'  => array('class' => 'js-select2'),
            ])
            ->add('q', TextType::class,[
                'label' => false,
                'required' => false,
                'attr'  => array(
                    'placeholder' => 'search.form.label.search',
                )
            ])
            ->add('submit', SubmitType::class,[
                'label' => 'form.search.submit',
                'attr'  => array('class' => 'btn btn-color text-light'),
            ]);
    }
    /**
    * {@inheritdoc}
    */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'dealsbundle_deal';
    }


}
