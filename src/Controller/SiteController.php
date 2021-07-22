<?php

namespace App\Controller;

use App\Entity\Proposition;
use App\Form\PropositionType;
use App\Repository\MorceauRepository;
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
   public function proposition(): Response
   {
        $proposition = new Proposition;

        $formProposition = $this->createForm(PropositionType::class, $proposition);

       return $this->render('site/proposition.html.twig', [
           'controller_name' => 'SiteController',
           'title' => 'Bienvenue',
           'formProposition' => $formProposition->createView()
       ]);;
   }





}
