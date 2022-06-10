<?php

namespace App\Controller;

use App\Entity\LieuTp;
use App\Form\LieuTpType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LieuTpController extends AbstractController
{
    /**
     * @Route("/lieu/tp/new", name="app_lieu_tp_new")
     */
    public function new(Request $request,ManagerRegistry $managerRegistry): Response
    {
        $lieuTp = new LieuTp();
        $form = $this->createForm(LieuTpType::class, $lieuTp);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            $manager->persist($lieuTp);
            $manager->flush();
            $this->addFlash('success', 'Lieu ajouté avec succès');
            return $this->redirectToRoute('app_lieu_tp');
        }

        return $this->render('lieu_tp/new.html.twig', [
            'form' => $form->createView(),
        ]);

    }
    //
    //liste des lieux
    /**
     * @Route("/lieu/tp", name="app_lieu_tp")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(LieuTp::class);
        $lieuTps = $repository->findAll();
        return $this->render('lieu_tp/list.html.twig', [
            'lieuTps' => $lieuTps,
        ]);
    }
    // supprimer un lieu
    /**
     * @Route("/lieu/tp/{id}/delete", name="lieuTp_delete")
     */
    public function delete(LieuTp $lieuTp,ManagerRegistry $doctrine): Response
    {
        $manager = $doctrine->getManager();
        $manager->remove($lieuTp);
        $manager->flush();
        $this->addFlash('success', 'Lieu supprimé avec succès');
        return $this->redirectToRoute('app_lieu_tp');
    }
    // modifier un lieu
    /**
     * @Route("/lieu/tp/{id}/edit", name="lieuTp_edit")
     */
    public function edit(Request $request,ManagerRegistry $doctrine,LieuTp $lieuTp): Response
    {
        $form = $this->createForm(LieuTpType::class, $lieuTp);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $doctrine->getManager();
            $manager->flush();
            $this->addFlash('success', 'Lieu modifié avec succès');
            return $this->redirectToRoute('app_lieu_tp');
        }
        return $this->render('lieu_tp/update.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/lieu/tp/{id}", name="lieuTp_show")
     */
    public function show(LieuTp $lieuTp): Response
    {
        return $this->render('lieu_tp/show.html.twig', [
            'lieuTp' => $lieuTp,
        ]);
    }






}
