<?php

namespace App\Form;

use App\Entity\Personne;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PersonneType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
            ->add('nom',TextType::class,array('required' => true))
            ->add('prenom', TextType::class)
            ->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) {
                $personne = $event->getData();
                $form = $event->getForm();
                if($personne != null && ($personne->getId() == null || $personne->getAdresse() != null)) {
                    $form->add('adresse', AdresseType::class);
                }
            })
            ->add('sports',ChoiceType::class, [
                'choices' => [
                    'Foot' => 'Football',
                    'Tennis' => 'Tennis',
                    'Rugby' => 'Rugby',
                    'Other' => null,
                    ],
            ])
            ->add('accepter', CheckboxType::class, ['mapped' => false])
            ->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
                $personne = $event->getData();
                if (!isset($personne['accepter']) || !$personne['accepter']) {
                    exit;
                }
            })
            ->add('save',SubmitType::class, ['label' => 'Ajouter une personne']);
    }

    public function configureOptions(OptionsResolver $resolver) {

        $resolver->setDefaults([
            'data_class' => Personne::class,
        ]);
    }
}
