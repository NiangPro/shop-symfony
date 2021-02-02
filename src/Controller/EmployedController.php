<?php

namespace App\Controller;

use App\Entity\Achat;
use App\Entity\User;
use App\Form\AchatType;
use App\Form\AddVenteType;
use App\Form\ClientSearchType;
use App\Form\ProductSearchType;
use App\Repository\ClientRepository;
use App\Repository\ProductRepository;
use App\Repository\VenteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class EmployedController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request)
    {
        $achat = new Achat();

        $form = $this->createForm(AchatType::class, $achat);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            dd($form->getData());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($achat);
            $entityManager->flush();
        }

        return $this->render('employed/index.html.twig', [
            'current_menu' => 'home',
            'date' => new \DateTime(),
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $errors = $authenticationUtils->getLastAuthenticationError();

        return $this->render("employed/login.html.twig", [
            'current_menu' => 'login',
            'error' => $errors
        ]);
    }

    /**
     * @Route("/deconnexion", name="logout")
     */
    public function logout()
    {
    }

    /**
     * @Route("/employe/monnaie", name="monnaie")
     */
    public function monnaie(ClientRepository $clientRepository)
    {
        $monnaies = [];
        $clients = $clientRepository->findMonnaies();

        foreach ($clients as $value) {
            $monnaies[] = $value->getMonnaie();
        }

        $totalMonnaies = array_sum($monnaies);

        return $this->render("employed/monnaie.html.twig", [
            'current_menu' => 'monnaie',
            'clients' => $clients,
            'totalMonnaies' => $totalMonnaies
        ]);
    }

    /**
     * @Route("/employe/emprunt", name="emprunt")
     */
    public function emprunt(ClientRepository $clientRepository)
    {
        $emprunts = [];
        $clients = $clientRepository->findEmprunts();

        foreach ($clients as $value) {
            $emprunts[] = $value->getEmprunt();
        }

        $totalEmprunt = array_sum($emprunts);



        return $this->render("employed/emprunt.html.twig", [
            'current_menu' => 'emprunt',
            'clients' => $clients,
            'totalEmprunt' => $totalEmprunt
        ]);
    }

    /**
     * @Route("/employe/recherche", name="search")
     */
    public function search(Request $request, ClientRepository $clientRepository, ProductRepository $productRepository)
    {
        $clients = [];
        $products = [];
        $typeSearch = "";

        $formClient = $this->createForm(ClientSearchType::class);
        $formProduct = $this->createForm(ProductSearchType::class);

        if ($formClient->handleRequest($request)->isSubmitted() && $formClient->isValid()) {
            $data = $formClient->getData();
            $clients = $clientRepository->findClientsByPrenomOrNom($data['nom']);
            $typeSearch = "client";
        }

        if ($formProduct->handleRequest($request)->isSubmitted() && $formProduct->isValid()) {
            $data = $formProduct->getData();
            $products = $productRepository->findProductsByCategorie($data['libelle']);
            $typeSearch = "produit";
        }

        return $this->render("employed/search.html.twig", [
            'current_menu' => 'search',
            'form_client' => $formClient->createView(),
            'clients' => $clients,
            'form_product' => $formProduct->createView(),
            'products' => $products,
            'typeSearch' => $typeSearch
        ]);
    }

    /**
     * @Route("/employe/boutique", name="boutique")
     */
    public function boutique(Request $request, VenteRepository $venteRepository)
    {

        $form = $this->createForm(AddVenteType::class);
        // DERNIERE VENTE
        $vente = $venteRepository->findLastVente();
        $lastVente = array_shift($vente);

        //  DATE ACTUELLE
        $currentDate = strtotime(date('Y-m-d'));
        $currentDate = date('Y-m-d', $currentDate);
        $currentDate = new \DateTime($currentDate);

        if ($lastVente == NULL) {
            $status = "aucun";
        } else if ($lastVente->getCloseAt() <= $currentDate) {
            $status = "passed";
        } else {
            $status = "present";
        }

        // ajout montant
        if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
            $lastVente->setMontant($form->get('montant')->getData() + $lastVente->getMontant());

            $this->getDoctrine()->getManager()->flush();
        }


        return $this->render('employed/boutique.html.twig', [
            'current_menu' => 'boutique',
            'vente' => $lastVente,
            'status' => $status,
            'form' => $form->createView()
        ]);
    }
}
