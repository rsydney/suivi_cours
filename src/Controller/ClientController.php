<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    #[Route('/client/liste', name: 'client.index')]
    public function index(ClientRepository $clientRepository): Response
    {

        $clients=$clientRepository->findAll();

        return $this->render('client/index.html.twig', [
            'dataClient' => $clients,
        ]);
    }
    #[Route('/client/create', name: 'client.create')]
    public function create(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $client= new Client();
        $form=$this->createForm(ClientType::class,$client);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form-> isValid()) {
            $entityManagerInterface->persist($client);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('client.index');
        }


        return $this->render('client/form.html.twig', [
            'formClient' => $form-> createView(),
        ]);
    }
}
