<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Member;
use App\Entity\User;
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
        $newUser = new User();
        $form = $this->createForm(RegisterType::class, $newUser);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
           
          // $test = new App\Entity\User();
           // $newUser->setCreatedAt(new \DateTime());
           // $newUser->setAvatar('logo.png');
            $plainPassword = $newUser->getPassword();
             $hash = $encoder->encodePassword($newUser, $plainPassword);

         /*   $newMember->setPass($this->passwordEncoder->encodePassword(
                            $newMember,
                $newMember->getPass()
                        ));
        */


            $newUser->setpassword($hash);
            $manager->persist($newUser);
    
                $manager->flush();
            return $this->redirectToRoute('login');
        }

        return $this->render('register/indexRegister.html.twig', [
           
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