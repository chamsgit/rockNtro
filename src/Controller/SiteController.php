<?php

namespace App\Controller;

use App\Entity\Vote;
use App\Entity\Boutton;
use App\Entity\Morceau;
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
    //    dump($proposition);
   }



//    public function unMorceau(Morceau $Morceau, Request $request, EntityManagerInterface $manager): Response
//     {
//         // L'id transmit dans l'URL est envoyé directement en argument de la fonction unMorceau(), ce qui nous permet d'avoir accès à l'id de l'Morceau a selectionner en BDD au sein de la méthode unMorceau()
//         // dump($id); // 6

//         // Importation de la classe MorceauRepository
//         // $repoMorceau = $this->getDoctrine()->getRepository(Morceau::class);
//         // dump($repoMorceau);

//         // find() : méthode mise à dispostion par Symfony issue de la classe MorceauRepository permettant de selectionner un élément de la BDD par son ID 
//         // $Morceau : tableau ARRAY contenant toutes les données de l'Morceau selectionné en BDD en fonction de l'ID transmit dans l'URL 

//         // SELECT * FROM Morceau WHERE id = 6 + FETCH 
//         // $Morceau = $repoMorceau->find($id); // 6
//         dump($request->server->get('DOCUMENT_ROOT'));

//         // TRAITEMENT COMMENTAIRE Morceau (formulaire + insertion)
//         $comment = new Comment; 

//         $formComment = $this->createForm(CommentType::class, $comment, [
//             'commentFront' => true
//         ]); 

//         $formComment->handleRequest($request); // $comment->setAuteur('$_POST[auteur]') | $comment->setCommentaire('$_POST[commentaire]')

//         if($formComment->isSubmitted() && $formComment->isValid())
//         {
//             $comment->setDate(new \DateTime());
//             $comment->setAuteur($this->getUser()->getPrenom() . ' ' . $this->getUser()->getNom());

//             // On établit la realtion entre le commentaire et l'Morceau (clé étrangère)
//             // setMorceau() : méthode issue de l'entité Comment qui permet de rensigner l'Morceau associé au commentaire
//             // Cette méthode attends en argument l'objet entité Morceau de la BDD et non la clé étrangère elle même
//             $comment->setMorceau($Morceau);

//             $manager->persist($comment);
//             $manager->flush();

//             // addFlash() : méthode permettant de déclarer un message de validation stocké en session
//             // arguements :
//             // 1. Identifiant du message (success)
//             // 2. Le message utilisateur
//             $this->addFlash('notice', "Le commentaire a été posté avec succès !");

//             /*
//                 session
//                 array(
//                     success => [
//                         0 => "Le commentaire a été posté avec succès !"
//                     ]
//                 )
//             */

//             dump($comment);

//             // Après l'insertion, on redirige l'internaute vers l'affichage de l'Morceau afin de rebooter le formulaire
//             return $this->redirectToRoute('blog_unMorceau', [
//                 'id' => $Morceau->getId()
//             ]);
//         }

//         return $this->render('blog/unMorceau.html.twig', [
//             'MorceauBDD' => $Morceau, // on transmet au template les données de l'Morceau selectionné en BDD afin de les traiter avec le langage Twig dans le template
//             'formComment' => $formComment->createView()
//         ]);
//     }

   }


