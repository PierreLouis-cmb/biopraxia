<?php

namespace App\Controller;

use App\Entity\LieuTp;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="app_dashboard")
     */
    public function index(ManagerRegistry $doctrine,UserRepository $ur): Response
    {

        $repository = $doctrine->getRepository(User::class);
        $users = $repository->findAll();
//dump($ur->nombreKilometreAll());
        return $this->render('dashboard/index.html.twig', [
           'users' => $users,
            'ur' => $ur,
        ]);

    }
}
