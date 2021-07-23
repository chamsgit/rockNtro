<?php

namespace App\Controller;

use App\Entity\Vote;
use App\Entity\Boutton;
use App\Entity\Proposition;
use App\Form\PropositionType;
use App\Repository\UserRepository;
use App\Repository\MorceauRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class SiteController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function morceau(MorceauRepository $reproMorceaux, Request $request, UserRepository $repoUser, EntityManagerInterface $manager): Response
    {
        // Pour selectionner des données dans une table SQL en BDD? nous devons importer la classe Repository qui correspond à la table SQL, c'est à dire à l'entité correspondante (Article)
        // Une classe Repository permet uniquement de formuler et d'executer des requetes SQL de selection (SELECT)
        // Cette classe contient des méthodes mis à disposition par Symfony pour formuler et executer des requetes SQL en BDD
        // getRepository() : méthode permettant d'importer la classe Repository d'une entité
        dump($request);

        // renvoi l'entité complète de l'utilisateur connecté
      
        if($request->request->count() > 0)
        {
            // permet de récupérer le morceau liké, l'entité complète
            //$morceau = $reproMorceaux->find($request->request->get('idMorceau'));
            
            $mor = $reproMorceaux->find($request->request->get('idMorceau'));
            dump($mor);
            //$vote->setUserId($user);  
            $user = $this->getUser();
            dump($user);

            $vote = new Vote();

            $vote->setMorceauId($mor);
            $vote->setUserId($user);

            $manager->persist($vote);
            $manager->flush();
        }

        

        $morceaux = $reproMorceaux->findAll();
        dump($morceaux);

        return $this->render('site/home.html.twig', [

            'morceauBDD' => $morceaux,

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


