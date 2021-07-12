<?php

namespace App\Controller;

use App\Entity\Bien;
use App\Repository\BienRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Listedesbiens extends AbstractController
{
    /**
     * @Route("/", name="home_annonce")
     */

    public function findallbien(BienRepository $bienRepository): Response
    {
        $biens = $bienRepository->findall();
        return $this->render('annonce/index.html.twig', [
            'lesbiens' => $biens,
        ]);
    }
}
