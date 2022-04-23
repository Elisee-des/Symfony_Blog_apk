<?php

namespace App\Controller\Admin;

use App\Entity\Annonces;
use App\Repository\AnnoncesRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
     * @Route("/activer/{id}", name="activer")
     */
    public function activer(Annonces $annonces, ManagerRegistry $managerRegi): Response
    {
        $annonces->setActive(($annonces->getActive()) ? false : true);

        $em = $managerRegi->getManager();
        $em->persist($annonces);
        $em->flush();

        return new Response("true");
    }

    /**
     * @Route("/supprimer/{id}", name="supprimer")
     */
    public function supprimer(Annonces $annonces, ManagerRegistry $managerRegi): RedirectResponse
    {
        $em = $managerRegi->getManager();
        $em->remove($annonces);
        $em->flush();

        $this->addFlash(
           'message',
           'Annnone supprimer avec success'
        );;
        return $this->redirectToRoute('admin_annonces_home');
    }
}
