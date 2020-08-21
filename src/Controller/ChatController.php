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

// API TOOLS
use Symfony\Component\Serializer\SerializerInterface;

class ChatController extends AbstractController
{

    /**
     * @Route("/chat", name="chat")
     */
    public function showMessage(ChatRepository $chatrepo, EntityManagerInterface $manager, SerializerInterface $serializer)
    {
        $ramdom = rand(0, 50);
        /* 
        $chatJson = file_get_contents('api/chats');
        $arrayChat = $serializer->decode($chatJson, 'json');
        */
        $chat = new Chat();
        //  $messages = $chatrepo->findAll();


        $repository = $this->getDoctrine()->getRepository(Chat::class);

        $message = $repository->findByExampleField();

        // $test2 = json_encode($test);
        // echo $test2;
        $messages = $serializer->serialize($message, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        //  $messages = json_encode($messages);
        dump($messages);
        // echo $messages;

        // $messages = $chatrepo->query();


        $form = $this->createFormBuilder($chat)
            ->setAction($this->generateUrl('chat_post'))
            ->add('message', TextareaType::class, [])
            ->getForm();

        return $this->render('chat/index.html.twig', [
            'controller_name' => 'ChatController',
            'formChat' => $form->createView(),
            'messages' => $messages,
            'ramdom' => $ramdom

        ]);
    }

    /**
     * @Route("/chatajax", name="chatajax")
     */
    public function showMessageAjax(ChatRepository $chatrepo, EntityManagerInterface $manager, SerializerInterface $serializer)
    {

        $chat = new Chat();


        $repository = $this->getDoctrine()->getRepository(Chat::class);

        $message = $repository->findByExampleField();



        $messages = $serializer->serialize($message, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        // dump($messages);
        // echo $messages;

        return $this->json(
            [
                'code' => 200,
                'message' => $messages,
                //'likes' => $likeRepo->count(['post' => $post])
            ],
            200
        );
    }




    /**
     * @Route("/chat/post", name="chat_post")
     */
    public function index(ChatRepository $test, Request $request, EntityManagerInterface $manager)
    {

        $ramdom = rand(0, 50);
        $pseudal = $this->getuser();
        $trouve =  $pseudal->getPseudo();
        $trouveID =  $pseudal->getId();

        $chat = new Chat();
        $newUser = new User();
        //  $messages = $test->findAll();


        $repository = $this->getDoctrine()->getRepository(Chat::class);

        $messages = $repository->findByExampleField();



        $chat->setPseudo($trouve);
        $chat->setCreatedAt(new \DateTime());
        $chat->setUser($pseudal);
        $manager->persist($chat);
        $chat->setMessage($_POST["form_message"]);
        $manager->flush();

        // ok 
        $form = $this->createFormBuilder($chat)

            ->setAction($this->generateUrl('chat_post'))
            ->add('message', TextareaType::class, [])
            ->getForm();

        $form->handleRequest($request);
        /*
        if ($form->isSubmitted() && $form->isValid()) {

            $chat->setPseudo($trouve);
            $chat->setCreatedAt(new \DateTime());
            $chat->setUser($pseudal);
            $manager->persist($chat);

            $manager->flush();
          
        
            return $this->redirectToRoute('chat');
        }

*/
        return $this->render('chat/index.html.twig', [
            'controller_name' => 'ChatController',
            'messages' => $messages,
            'formChat' => $form->createView(),
            'ramdom' => $ramdom

        ]);
    }
}
