<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Chat;
use App\Repository\ChatRepository;


use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ChatController extends AbstractController
{
    /**
     * @Route("/chat", name="chat")
     */
    public function index(ChatRepository $test, Request $request, EntityManagerInterface $manager)
    {
        $chat = new Chat();

        $messages = $test->findAll();

        $form = $this->createFormBuilder($chat)

        ->add('pseudo', textType::class, [
            
        ])
        ->add('message', TextareaType::class, [
           
           
        ])
        ->getForm();

         $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
           
            $chat->setCreatedAt(new \DateTime());
           
            $manager->persist($chat);
    
                $manager->flush();
            return $this->redirectToRoute('chat');
        }

        return $this->render('chat/index.html.twig', [
            'controller_name' => 'ChatController',
            'messages' => $messages,
            'formChat' => $form->createView()
        ]);
    }
}
