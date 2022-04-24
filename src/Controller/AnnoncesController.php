<?php

namespace App\Controller;

use App\Repository\AnnoncesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/annonces", name="annonces_")
 */
class AnnoncesController extends AbstractController
{
    /**
     * @Route("/details/{slug}", name="detail")
     */
    public function index($slug, AnnoncesRepository $annoncesRepo): Response
    {
        $annonce = $annoncesRepo->findBy(["slug" => $slug]);
        return $this->render('annonces/index.html.twig', [
            'controller_name' => 'AnnoncesController',
        ]);
    }
}
