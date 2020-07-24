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

class ProfilController extends AbstractController
{
    /**
     * @Route("/profil", name="profil")
     */
    public function index( EntityManagerInterface $manager, UserRepository $repo)
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

        // $id =  $_GET["id"];
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0)
        {
          
            $error = 1;
            if ($_FILES['image']['size'] <= 3000000)
            {           
                $informationsImage = pathinfo($_FILES['image']['name']);

                $extensionImage = $informationsImage['extension'];

                $extensionsArray = array('png', 'gif', 'jpg', 'jpeg');

                    if(in_array($extensionImage, $extensionsArray))
                    {
                        $adress = 'avatar/' . $id .'.'.$extensionImage;
                        $adress1 = $id.'.'.$extensionImage;
                        move_uploaded_file($_FILES['image']['tmp_name'],
                        $adress);
                         
                        $error = 0;   
                       
                       /* $query= $manager->createQuery(
                            'UPDATE App\Entity\User
                            SET avatar = :avatar
                            WHERE id = :id
                            '
                        )->setParameter('avatar',  $adress1, 'id', $id);
                        */
                        $user->setAvatar($adress1);

                        
                        $manager->persist($user);
    
                        $manager->flush();

                        return $this->render('profil/index.html.twig', [
                            'dataProfil' => $dataProfil,
                            
                        ]);


                    }
                    else
                    {
                        echo 'MDR DE TURBO LOL L\'EXTENSION N\'EST PAS BONNE';
                    }
            }
            else 
            {
                echo 'La taille est trop grande';
            }
        }
    
        
 
   
     
  

    }

}