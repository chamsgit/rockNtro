<?php

namespace App\Controller;

use App\Entity\Boutton;
use App\Entity\Proposition;
use App\Form\PropositionType;
use App\Repository\MorceauRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class SiteController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function morceau(MorceauRepository $reproMorceaux): Response
    {
        // Pour selectionner des données dans une table SQL en BDD? nous devons importer la classe Repository qui correspond à la table SQL, c'est à dire à l'entité correspondante (Article)
        // Une classe Repository permet uniquement de formuler et d'executer des requetes SQL de selection (SELECT)
        // Cette classe contient des méthodes mis à disposition par Symfony pour formuler et executer des requetes SQL en BDD
        // getRepository() : méthode permettant d'importer la classe Repository d'une entité

        // $reproArticles = $this->getDoctrine()->getRepository(Article::class);

        dump($reproMorceaux);

        $morceaux = $reproMorceaux->findAll();
        dump($morceaux);

        return $this->render('site/home.html.twig', [

            'morceauBDD' => $morceaux

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

  

}
