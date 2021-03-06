<?php

namespace App\Controller;

use App\Repository\PropertyRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home_annonce")
     */

    public function findallbien(PropertyRepository $bienRepository): Response
    {
        $biens = $bienRepository->findall();
        return $this->render('annonce/index.html.twig', [
            'biens' => $biens,
        ]);
    }
}
