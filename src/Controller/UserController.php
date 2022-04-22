<?php

namespace App\Controller;

use App\Entity\Annonces;
use App\Form\AnnoncesType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class UserController extends AbstractController
{
    /**
     * @Route("/users", name="users")
     */
    public function index(): Response
    {
        return $this->render('users/index.html.twig');
    }

    /**
     * @Route("/users/annonces/ajout", name="users_annonces_ajout")
     */
    public function ajoutAnnonce(Request $request, ManagerRegistry $managerRegistry): Response
    {
        $annonce = new Annonces();

        $form = $this->createForm(AnnoncesType::class, $annonce);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $annonce->setUsers($this->getUser());
            $annonce->setActive(false);

            $em = $managerRegistry->getManager();
            $em->persist($annonce);
            $em->flush();

            return $this->redirectToRoute('users');
        }
        
        return $this->render('users/annonce/ajout.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
