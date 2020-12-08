<?php

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class OnlyPersonneType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->remove('adresse')
            ->remove('sports');
    }

    public function getParent() {
        return PersonneType::class;
    }

}