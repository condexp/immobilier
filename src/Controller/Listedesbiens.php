<?php

namespace App\Controller;

use App\Entity\Biens;
use App\Entity\Images;
use App\Repository\BiensRepository;
use App\Repository\ImagesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Listedesbiens extends AbstractController
{
    /**
     * @Route("/", name="home_annonce")
     */

    public function findallbien(BiensRepository $bienRepository): Response
    {
        $biens = $bienRepository->findall();
        return $this->render('annonce/index.html.twig', [
            'biens' => $biens,
        ]);
    }
}
