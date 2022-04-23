<?php

namespace App\Controller\Admin;

use App\Entity\Categories;
use App\Form\CategoriesType;
use App\Form\CategoriesTypesType;
use App\Repository\CategoriesRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("admin/categories", name="admin_categories_")
 */
class CategoriesController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(CategoriesRepository $categoriesRepo): Response
    {
        return $this->render('admin/categories/index.html.twig', [
            'categories' => $categoriesRepo->findAll(),
        ]);
    }

    /**
     * @Route("/ajout", name="ajout")
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

            return $this->redirectToRoute('admin_categories_home');
        }


        return $this->render('admin/categories/ajout.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/modifier/{id}", name="modifier")
     */
    public function EditCategories(Categories $categories, Request $request, ManagerRegistry $managerRegistry): Response
    {
        $form = $this->createForm(CategoriesType::class, $categories);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $managerRegistry->getManager();
            $em->persist($categories);
            $em->flush();

            return $this->redirectToRoute('admin_categories_home');
        }


        return $this->render('admin/categories/ajout.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
