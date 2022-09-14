<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    public function __construct(EntityManagerInterface $manager, UserPasswordHasherInterface $passwordHasher){
        $this->manager = $manager;
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function index(Request $request): Response
    {
        $user = new User;

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $emptypassword = $form->get('password')->getData();

            if($emptypassword == null){
                $user->setPassword($user->getPassword());
            }else{
                $encode = $this->passwordHasher->hashPassword($user, $emptypassword);
                $user->setPassword($encode);
            }

            $this->manager->persist($user);
            $this->manager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('user/index.html.twig', [
            'userForm' => $form->createView(),
        ]);
    }
}
