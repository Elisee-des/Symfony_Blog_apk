<?php

namespace App\Controller\Admin;

use App\Entity\Annonces;
use App\Entity\Categories;
use App\Form\AnnoncesType;
use App\Form\CategoriesType;
use App\Form\CategoriesTypesType;
use App\Repository\AnnoncesRepository;
use App\Repository\CategoriesRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("admin/annonces", name="admin_annonces_")
 */
class AnnoncesController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(AnnoncesRepository $annoncesRepo): Response
    {
        return $this->render('admin/annonces/index.html.twig', [
            'annonces' => $annoncesRepo->findAll(),
        ]);
    }

    /**
     * @Route("/ajout", name="ajout")
     */
    public function ajoutCategories(Annonces $annonces ,Request $request, ManagerRegistry $managerRegistry): Response
    {
        $form = $this->createForm(AnnoncesType::class, $annonces);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $managerRegistry->getManager();
            $em->persist($annonces);
            $em->flush();

            return $this->redirectToRoute('admin_annonces_home');
        }


        return $this->render('admin/annonces/ajout.html.twig', [
            'annonces' => $form->createView(),
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
