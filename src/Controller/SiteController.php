<?php

namespace App\Controller;
// use App\Entity\Form;
use App\Entity\Proposition;
use App\Form\PropositionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route; 

class SiteController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('site/home.html.twig', [
            'controller_name' => 'SiteController',
            'title' => 'Bienvenue',
        ]);
    }

   /**
    * @Route("/proposition", name="proposition")
    */
   public function proposition(Request $request): Response  //request recuperation des données (GET)
   {
        $proposition = new Proposition; // instanciation de la classe

        $formProposition = $this->createForm(PropositionType::class, $proposition);// on reccupére le formulaire

        $formProposition->handleRequest($request);

        //si le formulaire est soumis
        if($formProposition->isSubmitted()){

                // on enregistre en BDD
            $em= $this->getDoctrine()->getManager();//($em pour entity manager), ($this pour reccuper les methodes du controleur)
            $em->persist($proposition);
            $em->flush();

            // return new Response("Proposition envoyé et en attente de validation");

        }



       return $this->render('site/proposition.html.twig', [
           'controller_name' => 'SiteController',
           'title' => 'Bienvenue',
           'formProposition' => $formProposition->createView()
         

       ]);;
       dump($proposition);
   }





}
