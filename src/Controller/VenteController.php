<?php

namespace App\Controller;

use App\Entity\Vente;
use App\Form\VenteType;
use App\Repository\VenteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/employe/vente")
 */
class VenteController extends AbstractController
{
    /**
     * @Route("/", name="vente_index", methods={"GET"})
     */
    public function index(VenteRepository $venteRepository): Response
    {
        return $this->render('vente/index.html.twig', [
            'ventes' => $venteRepository->findAll(),
            'current_menu' => 'list'
        ]);
    }

    /**
     * @Route("/new", name="vente_new", methods={"GET","POST"})
     */
    public function new(Request $request, VenteRepository $venteRepository): Response
    {
        $vente = new Vente();
        $form = $this->createForm(VenteType::class, $vente);

        // DERNIERE VENTE
        $ventes = $venteRepository->findLastVente();
        $lastVente = array_shift($ventes);

        //  DATE ACTUELLE
        $date = strtotime(date('Y-m-d'));
        $date = date('Y-m-d', $date);
        $date = new \DateTime($date);

        if ($lastVente == NULL || $lastVente->getCloseAt() <= $date) {
            $status = "aucun";
        } else {
            $status = "existe";
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //  DATE ACTUELLE
            $currentDate = strtotime(date('Y-m-d H:i:m') . '-2 hours');
            $currentDate = date('Y-m-d H:i:m', $currentDate);
            $vente->setCreatedAt(new \DateTime($currentDate));

            //  DATE FERMETURE
            $closeDate = strtotime(date('Y-m-d') . '+1 day');
            $closeDate = date('Y-m-d', $closeDate);
            $vente->setCloseAt(new \DateTime($closeDate));

            $numVente = count($venteRepository->findAll()) + 1;
            $vente->setNomVente("Vente N°" . $numVente);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($vente);
            $entityManager->flush();

            return $this->redirectToRoute('boutique');
        }

        return $this->render('vente/new.html.twig', [
            'vente' => $vente,
            'form' => $form->createView(),
            'current_menu' => 'add',
            'status' => $status
        ]);
    }

    /**
     * @Route("/{id}", name="vente_show", methods={"GET"})
     */
    public function show(Vente $vente): Response
    {
        return $this->render('vente/show.html.twig', [
            'vente' => $vente,
            'current_menu' => 'show'
        ]);
    }

    /**
     * @Route("/{id}/edit", name="vente_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Vente $vente): Response
    {
        $form = $this->createForm(VenteType::class, $vente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vente_index');
        }

        return $this->render('vente/edit.html.twig', [
            'vente' => $vente,
            'form' => $form->createView(),
            'current_menu' => 'edit'
        ]);
    }

    /**
     * @Route("/{id}", name="vente_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Vente $vente): Response
    {
        if ($this->isCsrfTokenValid('delete' . $vente->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($vente);
            $entityManager->flush();
        }

        return $this->redirectToRoute('vente_index');
    }
}
