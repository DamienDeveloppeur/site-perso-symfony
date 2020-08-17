<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ProfilController extends AbstractController
{
    /**
     * @Route("/profil", name="profil")
     */
    public function index(EntityManagerInterface $manager, UserRepository $repo)
    {
        $id =  $_GET["id"];
        $dataProfil  = new User();
        $dataProfil = $repo->find($id);


        return $this->render('profil/index.html.twig', [

            'dataProfil' => $dataProfil,

        ]);
    }

    /**
     * @Route("/profil?{id}", name="profil_change_avatar")
     */
    public function changeAvatar(User $user, UserRepository $repo,  Request $request, EntityManagerInterface  $manager, $id)
    {
        $dataProfil  = new User();
        $dataProfil = $repo->find($id);
        $adress1 = $dataProfil->updateAvatar($_FILES["image"], $id);

        $user->setAvatar($adress1);


        $manager->persist($user);

        $manager->flush();

        return $this->render('profil/index.html.twig', [
            'dataProfil' => $dataProfil,

        ]);
        // $id =  $_GET["id"];

    }

    /**
     * @Route("/profils", name="profil_updatePass")
     */
    public function updatePass(UserRepository $repo, Request $request, EntityManagerInterface  $manager)
    {

        $id =  $_GET["id"];

        $pseudal = $this->getuser();

        $dataProfil  = new User();

        $form = $this->createFormBuilder($dataProfil)

            ->add('password')
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            dump("ça marche");
            $dataProfil = $repo->find($id);
            //$dataProfil->setPassword();

            $manager->persist($pseudal);

            $manager->flush();
            return $this->render('navigation/index.html.twig', []);
        }

        return $this->render('profil/changePass.html.twig', [
            'controller_name' => 'profilController',
            'form' => $form->createView(),
        ]);
    }
}
