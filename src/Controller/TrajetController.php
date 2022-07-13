<?php

namespace App\Controller;

use App\Entity\LieuTp;
use App\Entity\Trajet;
use App\Form\TrajetType;
use App\Repository\TrajetRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrajetController extends AbstractController
{
    public function __construct(ManagerRegistry $doctrine, TrajetRepository $trajetRepository)
    {
        $this->entityManager = $doctrine->getManager();
        $this->trajetRepository = $trajetRepository;
    }
    /**
     * @Route("/trajet/new", name="trajet_new")
     */
    public function new(Request $request,ManagerRegistry $managerRegistry): Response
    {
        $trajet = new Trajet();
        $form = $this->createForm(TrajetType::class, $trajet);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();

            //Ici je stock en dur le nom du conducteur
            $user = $trajet->getUser();
            $trajet->setConducteur($user->getUsername());

            //Ici je stock en le nombre de kil du trajet
            $lieuTp = $trajet->getLieuTp();
            $trajet->setKilometrage($lieuTp->getKilometrage());

            //ici je stock + ajouter en dur dans le user le nombre de kilomètre parcouru
            $user->setTotalKilometre($trajet->getKilometrage());

            //ici je stock la date du dernier trajet fait par le user
            $dernierTrajet = $trajet->getDate();
            $user->setDerniertrajet($dernierTrajet);
            dump($dernierTrajet);
            $manager->persist($trajet);
            $manager->flush();
            $this->addFlash('success', 'Trajet ajouté avec succès');
            return $this->redirectToRoute('app_trajet');
        }

        return $this->render('trajet/new.html.twig', [
            'form' => $form->createView(),
        ]);

    }


    /**
     * @Route("/trajet", name="app_trajet")
     */
    public function index(): Response
    {
        //set null lieuTp if lieuTp does not correspond to an existing location in the database (id does not exist)
        $trajets = $this->trajetRepository->findAllWithLieu();
//        foreach ($trajets as $trajet) {
//            if ($trajet->getLieuTp() && !$this->entityManager->getRepository(LieuTp::class)->find($trajet->getLieuTp()->getId())) {
//                dump($trajet->getLieuTp());
//                $trajet->setLieuTp(null);
//                //$trajet->setLieuTp($this->entityManager->getRepository(LieuTp::class)->find($trajet->getLieuTp()));
//
//            }
//        }
        //$trajets = $this->trajetRepository->findAll();

        return $this->render('trajet/index.html.twig', [
            'trajets' => $trajets,

        ]);
    }

    /**
     * @Route("/trajet/edit/{id}", name="trajet_edit")
     */
    public function edit(Request $request, Trajet $trajet): Response
    {
        $form = $this->createForm(TrajetType::class, $trajet);
        $form->handleRequest($request);
        //set null lieuTp if lieuTp does not correspond to an existing location in the database (id does not exist)

        //ToDO: Bug : if the user deletes the location, the location is still in the database but not in the form

        if ($trajet->getLieuTp() && !$this->entityManager->getRepository(LieuTp::class)->find($trajet->getLieuTp()->getId())) {
            $trajet->setLieuTp(null);
            $this->addFlash('warning', 'Attention, le lieu du tp n\'existe pas dans la base de données');
        }


        if ($form->isSubmitted() && $form->isValid()) {
            //Ici je stock en dur le nom du conducteur
            $user = $trajet->getUser();
            $trajet->setConducteur($user->getUsername());

            //TODO : Stocker en dur le nombre de kilomètres du trajet
            $kill = $trajet->getKilometrage();
            $trajet->setKilometrage($kill);

            $this->entityManager->flush();
            $this->addFlash('success', 'Trajet modifié avec succès');
            return $this->redirectToRoute('app_trajet');
        }
        return $this->renderForm('trajet/edit.html.twig', [
            'form' => $form
        ]);
    }

    /**
     * @Route("/trajet/delete/{id}", name="trajet_delete")
     */
    public function delete(Trajet $trajet): Response
    {
        //Soustraction des killometres du a la suppression du trajet avec ma custom function dans user.php setSupprTotalKilometre()

        $user = $trajet->getUser();
        $lieuTp = $trajet->getLieuTp();
        $trajet->setKilometrage($lieuTp->getKilometrage());
        $user->setSupprTotalKilometre($trajet->getKilometrage());
//TODO: Attention, si un lieuTP n'existe plus dans la base données cela va provoquer une erreur lié a MySqlLite Contrainte NULL voir trajet.php relation lieuTp
        $this->entityManager->remove($trajet);
        $this->entityManager->flush();
        $this->addFlash('success', 'Trajet supprimé avec succès');
        return $this->redirectToRoute('app_trajet');
    }
}
