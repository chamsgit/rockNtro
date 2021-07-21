<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType; // ** je l'ai rajouté à la main car pas importée (?)//
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SecurityController extends AbstractController
{
 
/**
* @Route("/registration", name="security_registration")
 */
public function registrationn()
    {
    $user = new User(); // on précise à quelle entité va être relié notre formulaire
    $form = $this->createForm(RegistrationType::class, $user);// on appel la classe qui permet de construire le formulaire
    
    return $this->render('security/registration.html.twig',
    [ 'form' => $form->createView()]
    );
    
    }





}
