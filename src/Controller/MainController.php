<?php

namespace App\Controller;

use App\Repository\AnnoncesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(AnnoncesRepository $annoncesRepo, Request $request): Response
    {
        $annonces = $annoncesRepo->findAll();
        $form = $this->createForm(SearchType::class);
        $search = $form->handleRequest($request);
        
        // if ($form->isSubmitted() && $form->isValid()) { 
        //     //on recherche les annonces correspondant aux mots cles
        //     $annonces = $annoncesRepo->search($search->get('mots')->getData());
        // }

        return $this->render('main/index.html.twig', [
            "annonces"=> $annonces,
            "form" => $form->createView()
        ]);
    }
}
