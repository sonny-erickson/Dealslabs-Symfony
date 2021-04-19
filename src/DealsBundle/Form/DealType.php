<?php

namespace DealsBundle\Form;

use DealsBundle\Entity\Categorie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatorInterface;


class DealType extends AbstractType
{
    private $translator;
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
//        /** @var  $translator */
//        $translator = $options['translator'];
        $builder
            ->add('url', UrlType::class, [
                "label" => $this->translator->trans("deal.form.label.url"),
                "required" => true,
                "attr" => [
                    "class" => "well",
                    'placeholder' => 'deal.form.placeholderUrl',
                ]
            ])
            ->add('titre', TextType::class, [
                "label" => "deal.form.label.title",
                "required" => true,
                "attr" => [
                    "class" => "form-control",
                    'placeholder' => 'deal.form.placeholder.title'
                ]
            ])
            ->add('prixOrigine',MoneyType::class, [
                "label" => "deal.form.label.priceOrigin",
                'currency' => false,
                "required" => true,
                "attr" => [
                    'placeholder' => '0.00',
                ]
            ])
            ->add('prixPromo',MoneyType::class, [
                "label" => "deal.form.label.pricePromo",
                'currency' => false,
                "required" => true,
                "attr" => [
                    "type" => "number",
                    'placeholder' => '0.00',
                ]
            ])
            ->add('livraison',MoneyType::class, [
                "label" => "global.delivered.price",
                "currency" => false,
                "attr" => [
                    'placeholder' => '0.00',
                ]
            ])
            ->add('description', TextareaType::class, [
                "label" => "Description",
                "required" => false,
                "attr" => [
                    "class" => "form-control ",
                    'placeholder' => "deal.form.label.description"
                ]
            ])

            ->add('dateDebut', DateType::class, [
                "label" => "deal.form.label.start.date",
                'widget' => 'single_text',
                "required" => true,
                'attr' => [
                    "class" => "datepicker",
                ]
            ])
            ->add('dateExpiration', DateType::class, [
                "label" => "deal.form.label.date.expiration",
                'widget' => 'single_text',
                "required" => true,
                'attr' => [
                    "class" => "datepicker",
                ]
            ])
            ->add('localisation', TextType::class, [
                "label" => "deal.form.label.spot"
            ])
            ->add('categorie', EntityType::class,[
                "label" => "categorie.libelle",
                'class' => Categorie::class,
                'expanded' => false,
                'multiple' => false
            ])
            ->add('image', FileType::class,['label'=>'Image(JPG)'])
            ->add('isNational', ChoiceType::class, array(
                "label" => "National/Local",
                'choices' => array(
                    true => 'National',
                    false => 'Local',
                )
            ))
           ->add('counter', HiddenType::class, array(
                'data' => 1,
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'form.search.submit',
                'attr'  => array('class' => 'btn btn-color btn-lg mt-4 text-light'),
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DealsBundle\Entity\Deal'
        ));
        $resolver->setRequired('translator');
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'dealsbundle_deal';
    }


}
