<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use App\Repository\CommandeRepository;
use App\Entity\Commande;
use App\Entity\Produit;
use Symfony\Component\HttpFoundation\Request;
use App\Form\CommandeType;
use DateTime;
use App\Form\CommandeUpdateType;
use App\Repository\ProduitRepository;

class CommandeController extends AbstractController
{
    
    private $CommandeRepository;
    private $ProduitRepository;
    private $flashMessage;

    public function __construct(
        CommandeRepository $CommandeRepository,
        ProduitRepository $ProduitRepository,    
        FlashBagInterface $flashMessage
    ) {
        
        $this->CommandeRepository = $CommandeRepository;
        $this->ProduitRepository = $ProduitRepository;
        $this->flashMessage = $flashMessage;
    }
    #[Route('/commande', name: 'app_commande')]
    public function index(): Response
    {
        $produits = $this->ProduitRepository->findAll();
        $commandes = $this->CommandeRepository->findAll();
        return $this->render('commande/index.html.twig', [
            'controller_name' => 'CommandeController',
            "commandes" => $commandes,
            "produits" => $produits
        ]);
    }

    /**
     * @Route("/commande/{id}", name="commande_show")
     */

    public function showCommande($id)
    {
        $commandes = $this->CommandeRepository->find($id);
        return $this->render('commande/show.html.twig', [
            "commande" => $commandes
        ]);
    }
    /**
     * @Route("/create/commande/{id}", name="commande_create")
     */
    
    public function createCommande(Request $request, $id)
    {

        $commande = new Commande();
        $commande->setDate(new DateTime());
        $produit = $this-> ProduitRepository->find($id);
        $user=$produit-> getIdUtilisateur();
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $commande = $form->getData();
            $commande-> setIdProduit($id);
            $commande-> setIdUtilisateur($user);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commande);
            $entityManager->flush();
            $this->flashMessage->add("success", "Commande ajoutée !");
            return $this->redirectToRoute('app_commande');
        }

        return $this->render('commande/add.html.twig', [
            'form' => $form->createView()
        ]);
    }


    

    /**
     * @Route("/edit/commande/{id}", name="commande_edit")
     */

    public function editCommande(Commande $commande, Request $request)
    {
        $form = $this->createForm(CommandeUpdateType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $commande = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commande);
            $entityManager->flush();
            $this->flashMessage->add("success", "Commande modifiée !");
            return $this->redirectToRoute('app_commande');
        }

        return $this->render('commande/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/delete/commande/{id}", name="commande_delete")
     */

    public function deleteCommande(Commande $commande)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($commande);
        $entityManager->flush();
        $this->flashMessage->add("success", "Commande supprimée !");
        return $this->redirectToRoute('app_commande');
    }

}
