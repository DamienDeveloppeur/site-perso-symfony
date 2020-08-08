<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Chat;
use App\Entity\User;
use App\Repository\ChatRepository;
use App\Repository\UserRepository;

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
    public function showMessage(ChatRepository $test, EntityManagerInterface $manager)
    {

        $messages = $test->findAll();
        $chat = new Chat();
        $form = $this->createFormBuilder($chat)
            ->setAction($this->generateUrl('chat_post'))
            ->add('message', TextareaType::class, [])
            ->getForm();

        return $this->render('chat/index.html.twig', [
            'controller_name' => 'ChatController',
            'formChat' => $form->createView(),
            'messages' => $messages

        ]);
    }



    /**
     * @Route("/chat/post", name="chat_post")
     */
    public function index(ChatRepository $test, Request $request, EntityManagerInterface $manager)
    {
        $pseudal = $this->getuser();
        $trouve =  $pseudal->getPseudo();
        $trouveID =  $pseudal->getId();

        $chat = new Chat();
        $newUser = new User();
         $messages = $test->findAll();

        $form = $this->createFormBuilder($chat)

            ->setAction($this->generateUrl('chat_post'))
            ->add('message', TextareaType::class, [])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $chat->setPseudo($trouve);
            $chat->setCreatedAt(new \DateTime());
            $chat->setUser($pseudal);
            $manager->persist($chat);

            $manager->flush();
           /* return $this->json([
                'code' => 200,
                'message' => 'message bien eSnvoyé',
                

            ], 200);
            */

            return $this->render('chat/index.html.twig', [
                'controller_name' => 'ChatController',
                'messages' => $messages,
                'formChat' => $form->createView(),
    
            ]);

        }
        return $this->render('chat/index.html.twig', [
            'controller_name' => 'ChatController',
            'messages' => $messages,
            'formChat' => $form->createView(),

        ]);
    
    }
}
