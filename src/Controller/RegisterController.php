<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Member;
use App\Repository\RegisterRepository;


use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


use App\Form\RegisterType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;



class RegisterController extends AbstractController
{





      /**
     * @Route("/register", name="indexRegister")
     */
    public function indexRegister(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        $newMember = new Member();
        $form = $this->createForm(RegisterType::class, $newMember);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
           
          // $test = new App\Entity\Member();
            $newMember->setCreatedAt(new \DateTime());
            $newMember->setAvatar('logo.png');
            $plainPassword = $newMember->getPass();
             $hash = $encoder->encodePassword($newMember, $plainPassword);

         /*   $newMember->setPass($this->passwordEncoder->encodePassword(
                            $newMember,
                $newMember->getPass()
                        ));
        */


            $newMember->setpass($hash);
            $manager->persist($newMember);
    
                $manager->flush();
            return $this->redirectToRoute('login');
        }

        return $this->render('register/indexRegister.html.twig', [
            'controller_name' => 'RegisterController',
            'formRegister' => $form->createView(),
        ]);
    }
/**
 * @Route("/connexion", name="login")
 */
    public function login(){
        return $this->render('register/login.html.twig');
    }
}