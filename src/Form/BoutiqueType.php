<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\SousCategorie;
use App\Entity\SalleExposition;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Test\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BoutiqueType extends AbstractType
{
    // public function buildForm(FormBuilderInterface $builder, array $options): void
    // {
    //     $builder
    //         ->add('nomSalle')
    //         ->add('description')
    //         ->add('imageName')
    //         ->add('domaine', EntityType::class, [
    //             'class' => SousCategorie::class,
    //             'placeholder' => 'What should we eat?',
    //             'autocomplete' => true,
    //             'label' => 'Domaine(s)',
    //             'multiple' => true
    //         ])
    //         // ->add('adresseSalle')
    //         ->add('categorie');
    // }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'placeholder' => '',
            ]);

        $builder->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();

                // this would be your entity, i.e. SportMeetup
                $data = $event->getData();


                $categorie = $data->getCategorie();
                $sousCategories = null === $categorie ? [] : $categorie->getSousCategories();

                $form->add('domaine', EntityType::class, [
                    'class' => SousCategorie::class,
                    'placeholder' => '',
                    'choices' => $sousCategories,
                ]);
            }
        );
    }




    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SalleExposition::class,
        ]);
    }
}
