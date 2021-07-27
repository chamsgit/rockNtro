<?php

namespace App\Controller;

use App\Entity\Vote;
use App\Entity\Morceau;
use App\Entity\Commentaire;
use App\Entity\Proposition;
use App\Form\CommentaireType;
use App\Form\PropositionType;
use App\Repository\CommentaireRepository;
use App\Repository\UserRepository;
use App\Repository\MorceauRepository;
use App\Repository\PropositionRepository;
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
        // Pour selectionner des données dans une table SQL en BDD? nous devons importer la classe Repository qui correspond à la table SQL, c'est à dire à l'entité correspondante (Morceau)
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


        

        // $reproMorceaus = $this->getDoctrine()->getRepository(Morceau::class);

        dump($request);
        // dump($reproMorceaux);


        $morceaux = $reproMorceaux->findAll();
        // dump($morceaux);

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
        if($formProposition->isSubmitted())
        {

                // on enregistre en BDD
            $em= $this->getDoctrine()->getManager();//($em pour entity manager), ($this pour reccuper les methodes du controleur)
            $em->persist($proposition);
            $em->flush();
        }

       return $this->render('site/proposition.html.twig', [
           'controller_name' => 'SiteController',
           'title' => 'Bienvenue',
           'formProposition' => $formProposition->createView()       

       ]);
  
   }

// ----*** importation d'un morceau par son id  et affichage dans la page "morceau"

    /**
     * Méthode permettant d'afficher le détail d'un article
     * 
     * @Route("/home/{id}", name="home_show")
     */

    public function show(Morceau $morceau, CommentaireRepository $commentaire ,Request $request, EntityManagerInterface $manager): Response
    {
   //TRAITEMENT COMMENTAIRE ARTICLE
    $commentaire = new Commentaire;
     $formCommentaire = $this->createForm(CommentaireType::class, $commentaire);

    $formCommentaire->handleRequest($request);
        
        
          if($formCommentaire->isSubmitted()&& $formCommentaire->isValid())
            {
                $commentaire->setDate(new \dateTime());
               $commentaire->setMorceauId($morceau);

                $manager->persist($commentaire);
                $manager ->flush();

                //message  addFlash appelé 'sucess' de validation du commentaire, stocké dans la 'session' utilisateur
                $this->addFlash('success',"Votre commentaire posté avec succés ! bravo ");

               // dump($commentaire);

                return $this->redirectToRoute('home_show', [
                    'id' => $morceau->getId()
                ]);
            }
       

       //----**** affichage du morceau dans la page show *****---------
        
        return $this ->render('site/show.html.twig', [
            'morceauBDD'=>$morceau,
            'formCommentaire' => $formCommentaire->createView(),
           'commentaireBDD'=> $commentaire,
        ]);
    }


/**
 * @Route("/entrer", name="entrer")
 */
    public function nouveaute(PropositionRepository $repoProposition, Request $request, EntityManagerInterface $manager): Response

    {
        $propositions = $repoProposition -> findAll();
        // dump($propositions);
       

        return $this->render('site/nouveaute.html.twig', [
            'propositionBDD' => $propositions
            
 
        ]);
    }
   }



