<?php

namespace App\Controller;

use App\Entity\Proposition;
use App\Form\PropositionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
