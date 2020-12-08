<?php

namespace App\Controller;

//use App\Form\OnlyPersonneType;
use App\Entity\Personne;
use App\Form\PersonneType;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PersonneController extends AbstractController {


    /**
     * @Route("/", name="index")
     */
    public function index() {
        return $this->render('personne/index.html.twig');
    }

    /**
     *@Route("/personne/add", name="personne_add")
     */

    public function addForm(EntityManagerInterface $manager, Request $request) {

        $personne = new Personne();

        $form = $this->createForm(PersonneType::class, $personne);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $personne = $form->getData();
            $manager->persist($personne);
            $manager->flush();
            return $this->redirectToRoute('index');
        }

        return $this->render('personne/add.html.twig', [
            'controller_name' => 'PersonneController',
            'form' => $form->createView(),
            ]);
    }

    /**
     * @Route ("/personne/edit/{id}", name = "personne_update")
     */

    public function updatePersonne(Personne $personne, EntityManagerInterface $manager, Request $request) {
        $form = $this->createForm(PersonneType::class, $personne);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $personne = $form->getData();
            $manager->flush();
            return $this->redirectToRoute('index');
        }

        return $this->render('personne/add.html.twig', [
            'controller_name' => 'PersonneController',
            'form' => $form->createView(),
        ]);
    }
}