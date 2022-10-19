<?php

namespace App\Form;

use App\Entity\Annonce;
use App\Entity\Categorie;
use App\Entity\SousCategorie;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\Dropzone\Form\DropzoneType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AnnonceFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelleAnnonce')
            ->add('description')
            ->add('prix', TextType::class, [
                'attr' => [
                    'placeholder' => 'CFA',
                ],
            ])
            // ->add('lienVideo')
            ->add('categorie', EntityType::class, [
                'mapped' => false,
                'class' => Categorie::class,
                'placeholder' => 'Choisissez une categorie',
            ]);
        $formModifier = function (FormInterface $form, Categorie $categorie = null) {
            $sousCategories = null === $categorie ? [] : $categorie->getSousCategories();

            $form->add('souscategories', EntityType::class, [
                'class' => Departements::class,
                'choices' => $sousCategories,
                'required' => false,
                'choice_label' => 'name',
                'placeholder' => 'sousCategories (Choisir une région)',
                'attr' => ['class' => 'custom-select'],
                'label' => 'sousCategories'
            ]);
        };
        $builder->get('categorie')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                $categorie = $event->getForm()->getData();
                $formModifier($event->getForm()->getParent(), $categorie);
            }
        );
        // ->add('submit', SubmitType::class);
        // ->add('adresseAnnonce');
    }



    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}
