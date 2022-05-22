<?php

namespace App\Controller;

use App\Entity\Company;
use App\Form\CompanyType;
use App\Repository\CompanyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/societes")
 */

class SocieteController extends AbstractController
{


    #[Route('/', name: 'societes')]
    public function societes(CompanyRepository $companyRepository): Response
    {
        $companies = $companyRepository->findAll();
        return $this->render('societe/societes.html.twig', [
            'controller_name' => 'MainController',
            'companies' => $companies,
        ]);
    }

    /**
     * @Route("/{id}", name="vue_societe", requirements={"id"="\d+"}, methods={"GET","POST"})
     */
    public function vueSociete(Company $company, EntityManagerInterface $manager): Response
    {

        return $this->render('societe/vueSociete.html.twig',[
            'company' => $company,
        ]);

    }
    /**
     * @Route("/new", name="add_societe")
     */

    public function addSociete(Request $request, EntityManagerInterface $manager): Response
    {
        $company = new Company();

        $form = $this->createForm(CompanyType::class, $company);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($company);
            $manager->flush();


            return $this->redirectToRoute('societes');

        }

        return $this->render('societe/ajoutSociete.html.twig',[
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/{id}/edit", name="edit_societe", requirements={"id"="\d+"}, methods={"GET","POST"})
     */

    public function updateSociete(Company $company, Request $request, EntityManagerInterface $manager): Response
    {

        $form = $this->createForm(CompanyType::class, $company);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->flush();

            return $this->redirectToRoute('societes');

        }

        return $this->render('societe/modifSociete.html.twig',[
            'form' => $form->createView(),
            'company' => $company
        ]);

    }


    #[Route('/{id}/delete', name: 'delete_societe')]
    public function deleteSociete(Company $company,EntityManagerInterface $manager): Response
    {
        $manager->remove($company);
        $manager->flush();
        return $this->redirectToRoute('societes');
    }


}
