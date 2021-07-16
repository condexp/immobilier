<?php

namespace App\Controller;

use App\Entity\Biens;
use App\Entity\Images;
use App\Entity\Users;
use App\Form\BiensType;
use App\Repository\BiensRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/biens")
 */
class BiensController extends AbstractController
{
    /**
     * @Route("/", name="biens_index", methods={"GET"})
     */
    public function index(BiensRepository $biensRepository): Response
    {
        return $this->render('biens/index.html.twig', [
            'biens' => $biensRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="biens_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {

        $bien = new Biens();
        //$myuser = new Users;
        $form = $this->createForm(BiensType::class, $bien);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            // On récupère les images transmises
            $images = $form->get('images')->getData();

            // On boucle sur les images
            foreach ($images as $image) {
                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                // dd($image);

                // On copie le fichier dans le dossier uploads
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );

                // On stocke l'image dans la base de données (son nom)
                $img = new Images();
                $img->setName($fichier);
                $bien->addImage($img);

                // On recupere l'id de l'user connecter et on insere son id 
                // en base de donnée sur la table des biens.
                $bien->setUsers($this->getUser());
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($bien);
            $entityManager->flush();

            return $this->redirectToRoute('biens_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('biens/new.html.twig', [
            'bien' => $bien,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="biens_show", methods={"GET"})
     */
    public function show(Biens $bien): Response
    {
        return $this->render('biens/show.html.twig', [
            'bien' => $bien,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="biens_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Biens $bien): Response
    {
        $form = $this->createForm(BiensType::class, $bien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            // On récupère les images transmises
            $images = $form->get('images')->getData();

            // On boucle sur les images
            foreach ($images as $image) {
                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();

                // On copie le fichier dans le dossier uploads
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );

                // On stocke l'image dans la base de données (son nom)
                $img = new Images();
                $img->setName($fichier);
                $bien->addImage($img);
            }


            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('biens_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('biens/edit.html.twig', [
            'bien' => $bien,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="biens_delete", methods={"POST"})
     */
    public function delete(Request $request, Biens $bien): Response
    {
        if ($this->isCsrfTokenValid('delete' . $bien->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($bien);
            $entityManager->flush();
        }

        return $this->redirectToRoute('biens_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/supprime/image/{id}", name="biens_delete_image", methods={"DELETE"})
     */
    public function deleteImage(Images $image, Request $request)
    {
        $data = json_decode($request->getContent(), true);

        // On vérifie si le token est valide
        if ($this->isCsrfTokenValid('delete' . $image->getId(), $data['_token'])) {
            // On récupère le nom de l'image
            $name = $image->getName();
            // On supprime le fichier
            unlink($this->getParameter('images_directory') . '/' . $name);

            // On supprime l'entrée de la base
            $em = $this->getDoctrine()->getManager();
            $em->remove($image);
            $em->flush();

            // On répond en json
            return new JsonResponse(['success' => 1]);
        } else {
            return new JsonResponse(['error' => 'Token Invalide'], 400);
        }
    }
}
