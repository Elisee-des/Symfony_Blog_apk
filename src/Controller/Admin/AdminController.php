<?php

namespace App\Controller\Admin;

use App\Entity\Categories;
use App\Entity\Users;
use App\Form\CategoriesType;
use App\Form\EditUsersType;
use App\Repository\UsersRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("admin", name="admin_")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/categories/ajout", name="categories_ajout")
     */
    public function ajoutCategories(Request $request, ManagerRegistry $managerRegistry): Response
    {
        $categories = new Categories();

        $form = $this->createForm(CategoriesType::class, $categories);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $managerRegistry->getManager();
            $em->persist($categories);
            $em->flush();

            return $this->redirectToRoute('admin_home');
        }


        return $this->render('admin/categories/ajout.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/users", name="users")
     */
    public function userslist(UsersRepository $users): Response
    {
        return $this->render('admin/users.html.twig', [
            'users' => $users->findAll(),
        ]);
    }

        /**
     * @Route("/users/modifier/{id}", name="users_modifier")
     */
    public function editUser(Users $user, Request $request, ManagerRegistry $managerRegistry): Response
    {
        $form = $this->createForm(EditUsersType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $managerRegistry->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash(
               'message',
               'Utilisateur modifier avec success'
            );

            return $this->redirectToRoute('admin_users');
        }
        return $this->render('admin/editusers.html.twig', [
            "userForm" => $form->createView()
        ]);
    }
    
}

