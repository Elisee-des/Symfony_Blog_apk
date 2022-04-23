<?php

namespace App\Controller;

use App\Entity\Annonces;
use App\Entity\Users;
use App\Form\AnnoncesType;
use App\Form\EditProfilType;
use App\Repository\UsersRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
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

    /**
     * @Route("/users/profil/modifier", name="users_profil_modifier")
     */
    public function editProfil(Request $request, ManagerRegistry $managerRegistry): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(EditProfilType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $managerRegistry->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash(
                'success',
                'Profil mise a jour avec success'
            );
            return $this->redirectToRoute('users');
        }

        return $this->render('users/editprofile.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/users/verifpass/", name="users_verif_pass")
     */
    public function verifPass(Request $request, UserPasswordHasherInterface $userPasswordHasher, UsersRepository $usersRepo): Response
    {
        if ($request->isMethod("POST")) {

            $user = $usersRepo->findBy(["name"=>"Keyboard"]);
            $passwordhasher = $userPasswordHasher->hashPassword($user, $request->request->get("oldpass"));

            if ($passwordhasher  ==  $user->getPassword()) {

                $this->addFlash(
                    'success',
                    'Mot de passe verifier avec success'
                );
                return $this->redirectToRoute('users_pass_modifier');
            } else {
                $this->addFlash(
                    'error',
                    'Votre ancien mot de pass est erroné'
                );
            }
        }

        return $this->render('users/verifpass.html.twig');
    }

    /**
     * @Route("/users/pass/modifier", name="users_pass_modifier")
     */
    public function editPass(Request $request, ManagerRegistry $managerRegistry, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        if ($request->isMethod("POST")) {

            $user = $this->getUser();


            if ($request->request->get("pass") == $request->request->get("pass2")) {
                $user->setPassword($userPasswordHasher->hashPassword($user, $request->request->get("pass")));

                $em = $managerRegistry->getManager();
                $em->flush();

                $this->addFlash(
                    'message',
                    'Mot de passe modifier avec success'
                );

                return $this->redirectToRoute('users');
            } else {
                $this->addFlash(
                    'message',
                    'Les deux mot de passe ne sont pas identique'
                );
            }
        }
        return $this->render('users/editpass.html.twig');
    }
}
