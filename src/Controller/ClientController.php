<?php

namespace App\Controller;

use App\Entity\BusinessClient;
use App\Entity\ParticularClient;
use App\Form\BusinessClientType;
use App\Form\ParticularClientType;
use App\Repository\BusinessClientRepository;
use App\Repository\ParticularClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/clients")
 */

class ClientController extends AbstractController
{
    #[Route('/', name: 'clients')]
    public function clients(BusinessClientRepository $businessClientRepository,ParticularClientRepository $particularClientRepository): Response
    {
        $businessClients = $businessClientRepository->findAll();
        $particularClients = $particularClientRepository->findAll();
        return $this->render('client/clients.html.twig', [
            'controller_name' => 'MainController',
            'businessClients' => $businessClients,
            'particularClients' => $particularClients
        ]);

    }

    /**
     * @Route("/particulier/{id}", name="vue_parClient", requirements={"id"="\d+"}, methods={"GET","POST"})
     */
    public function vueParClient(ParticularClient $particularClient, EntityManagerInterface $manager): Response
    {
        //dump($particularClient);die;
        return $this->render('client/vueParClient.html.twig',[
            'particularClient' => $particularClient,
        ]);

    }

    /**
     * @Route("/professionnel/{id}", name="vue_proClient", requirements={"id"="\d+"}, methods={"GET","POST"})
     */
    public function vueProClient(BusinessClient $businessClient, EntityManagerInterface $manager): Response
    {

        return $this->render('client/vueProClient.html.twig',[
            'businessClient' => $businessClient,
        ]);

    }

    #[Route('/new', name: 'add_client')]
    public function addClient(): Response
    {
        return $this->render('client/ajoutClient.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/particulier/new", name="add_parClient")
     */
    public function addParClient(Request $request, EntityManagerInterface $manager): Response
    {
        $client = new ParticularClient();

        $form = $this->createForm(ParticularClientType::class, $client);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($client);
            $manager->flush();


            return $this->redirectToRoute('clients');

        }

        return $this->render('client/ajoutParClient.html.twig', [
            'controller_name' => 'MainController',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/professionnel/new", name="add_proClient")
     */
    public function addProClient(Request $request, EntityManagerInterface $manager): Response
    {
        $client = new BusinessClient();

        $form = $this->createForm(BusinessClientType::class, $client);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($client);
            $manager->flush();


            return $this->redirectToRoute('clients');

        }

        return $this->render('client/ajoutProClient.html.twig', [
            'controller_name' => 'MainController',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/particulier/{id}/edit", name="edit_parClient", requirements={"id"="\d+"}, methods={"GET","POST"})
     */

    public function updateParClient(ParticularClient $particularClient, Request $request, EntityManagerInterface $manager): Response
    {

        $form = $this->createForm(ParticularClientType::class, $particularClient);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->flush();

            return $this->redirectToRoute('clients');

        }

        return $this->render('client/modifParClient.html.twig',[
            'form' => $form->createView(),
            'particularClient' => $particularClient
        ]);

    }

    /**
     * @Route("/professionnel/{id}/edit", name="edit_proClient", requirements={"id"="\d+"}, methods={"GET","POST"})
     */

    public function updateProClient(BusinessClient $businessClient, Request $request, EntityManagerInterface $manager): Response
    {

        $form = $this->createForm(BusinessClientType::class, $businessClient);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->flush();

            return $this->redirectToRoute('clients');

        }

        return $this->render('client/modifProClient.html.twig',[
            'form' => $form->createView(),
            'businessClient' => $businessClient
        ]);

    }

    #[Route('/particulier/{id}/delete', name: 'delete_parClient')]
    public function deleteParClient(ParticularClient $particularClient,EntityManagerInterface $manager): Response
    {
        $manager->remove($particularClient);
        $manager->flush();
        return $this->redirectToRoute('clients');
    }

    #[Route('/professionnel/{id}/delete', name: 'delete_proClient')]
    public function deleteProClient(BusinessClient $businessClient,EntityManagerInterface $manager): Response
    {

        $manager->remove($businessClient);
        $manager->flush();
        return $this->redirectToRoute('clients');
    }


}
