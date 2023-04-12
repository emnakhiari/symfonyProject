<?php

namespace App\Form;

use App\Entity\Commande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;



use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CommandeUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('idUtilisateur', NumberType::class, [
            //     'attr' => [
            //         'class' => 'form-control',
            //     ],
            // ])
            ->add('idProduit', NumberType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            // ->add('date', DateType::class, [
            //     'attr' => [
            //         'class' => 'form-control',
            //     ],
            // ])
            // ->add('role', ChoiceType::class, [
            //     'choices'  => [
            //         'Echange' => 'echange',
            //         'Achat' => 'achat',

            //     ],
            //     'attr' => [
            //         'class' => 'form-control',
            //     ],
            // ])
            ->add('status',ChoiceType::class, [
            'choices'  => [
                '' => '',             
                'Non confirmé' => '0',
                'Confirmé' => '1',
                ],
            ])
            ->add('idLivreur', ChoiceType::class, [
            'choices'  => [
                '' => '',             
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                ],
            ])
            // ->add('idUtilisateura', NumberType::class, [
            //     'attr' => [
            //         'class' => 'form-control',
            //     ],
            // ])
            // ->add('dateLivraison', DateType::class, [
            //     'attr' => [
            //         'class' => 'form-control',
            //     ],
            // ])
            ->add('dateConfirmation', DateType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('Valider', SubmitType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
