<?php

namespace App\Controller;

use App\Entity\Annonces;
use App\Entity\Comments;
use App\Form\CommentsType;
use App\Repository\AnnoncesRepository;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/annonces", name="annonces_")
 */
class AnnoncesController extends AbstractController
{
    /**
     * @Route("/details/{slug}", name="details")
     */
    public function details(Annonces $annonce, $slug, AnnoncesRepository $annoncesRepo, Request $request, ManagerRegistry $managerRegi): Response
    {
        $annonce = $annoncesRepo->findOneBy(["slug" => $slug]);
        // if (!$annonce) {
        //     throw new NotFoundHttpException('Pas d\'annonce trouver');
            
        // }

        $comment = new Comments();

        $commentForm = $this->createForm(CommentsType::class, $comment);

        $commentForm->handleRequest($request);
        
        if ($commentForm->isSubmitted() && $commentForm->isValid()) { 

            $comment->setCreatedAt(new DateTime());
            $comment->setAnnonces($annonce);

            $em = $managerRegi->getManager();
            $em->persist($comment);
            $em->flush();

            $this->addFlash(
               'success',
               'Commentaire ajouter avec success'
            );
            return $this->redirectToRoute('annonces_details', ["slug" => $annonce->getSlug()]);
        }
        
        return $this->render('annonces/details.html.twig', [
            "annonce" => $annonce,
            "commentForm" => $commentForm->createView()
        ]);
    }
}
