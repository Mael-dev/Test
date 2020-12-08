<?php

namespace App\Form;

use App\Entity\Personne;
use App\Entity\Sport;


use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\AbstractType;
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
            ->add('sports', EntityType::class, [
                'class' => Sport::class,
                'choice_label' => 'nom',
                'query_builder' => function (EntityRepository $repo) {
                return $repo->createQueryBuilder('s');
                },
                'label' => 'Sports préférés',
                'multiple' => true
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
