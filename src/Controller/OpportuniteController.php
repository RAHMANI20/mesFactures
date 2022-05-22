<?php

namespace App\Controller;

use App\Entity\Bill;
use App\Entity\BillCredit;
use App\Entity\Deposit;
use App\Entity\Opportunity;
use App\Entity\Quotation;
use App\Form\OpportunityType;
use App\Repository\OpportunityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/opportunites")
 */

class OpportuniteController extends AbstractController
{
    #[Route('/', name: 'opportunites')]
    public function opportunites(OpportunityRepository $opportunityRepository): Response
    {
        $opportunities = $opportunityRepository->findAll();
        return $this->render('opportunite/opportunites.html.twig', [
            'opportunities' => $opportunities,
        ]);
    }

    #[Route('/en_cours', name: 'opportunites_en_cours')]
    public function opportunitesEnCours(OpportunityRepository $opportunityRepository): Response
    {
        $opportunities = $opportunityRepository->findBy([
            'state' => 'En cours'
        ]);
        return $this->render('opportunite/opportunites.html.twig', [
            'opportunities' => $opportunities,
        ]);
    }

    #[Route('/remportees', name: 'opportunites_remportees')]
    public function opportunitesRemportees(OpportunityRepository $opportunityRepository): Response
    {
        $opportunities = $opportunityRepository->findBy([
            'state' => 'Remporté'
        ]);
        return $this->render('opportunite/opportunites.html.twig', [
            'opportunities' => $opportunities,
        ]);
    }

    #[Route('/perdues', name: 'opportunites_perdues')]
    public function opportunitesPerdues(OpportunityRepository $opportunityRepository): Response
    {
        $opportunities = $opportunityRepository->findBy([
            'state' => 'Perdu'
        ]);
        return $this->render('opportunite/opportunites.html.twig', [
            'opportunities' => $opportunities,
        ]);
    }

    /**
     * @Route("/{id}", name="vue_opportunite", requirements={"id"="\d+"}, methods={"GET","POST"})
     */
    public function vueOpportunite(Opportunity $opportunity, EntityManagerInterface $manager): Response
    {

        return $this->render('opportunite/vueOpportunite.html.twig',[
            'opportunity' => $opportunity
        ]);

    }


    #[Route('/new', name: 'add_opportunite')]
    public function addOpportunite(Request $request, EntityManagerInterface $manager): Response
    {
        $opportunity = new Opportunity();

        $form = $this->createForm(OpportunityType::class, $opportunity);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($opportunity);
            $manager->flush();


            return $this->redirectToRoute('opportunites');

        }

        return $this->render('opportunite/ajoutOpportunite.html.twig',[
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/{id}/edit", name="edit_opportunite", requirements={"id"="\d+"}, methods={"GET","POST"})
     */

    public function updateOpportunite(Opportunity $opportunity, Request $request, EntityManagerInterface $manager): Response
    {

        $form = $this->createForm(OpportunityType::class, $opportunity);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $opportunity->setLastUpdate(new \DateTime('now'));
            $manager->flush();

            return $this->redirectToRoute('opportunites');

        }

        return $this->render('opportunite/modifOpportunite.html.twig',[
            'form' => $form->createView(),
            'opportunity' => $opportunity
        ]);

    }

    #[Route('/{id}/delete', name: 'delete_opportunite')]
    public function deleteSociete(Opportunity $opportunity,EntityManagerInterface $manager): Response
    {
        $manager->remove($opportunity);
        $manager->flush();
        return $this->redirectToRoute('opportunites');
    }


    /**
     * @Route("/{id}/enCoursOpportunite", name="enCours_opportunite", requirements={"id"="\d+"}, methods={"GET"})
     */

    public function enCoursOpportunite( Opportunity $opportunity, EntityManagerInterface $manager): Response
    {
        $opportunity->setState('En cours');
        $manager->flush();
        return $this->redirectToRoute('vue_opportunite',['id' => $opportunity->getId()]);
    }

    /**
     * @Route("/{id}/remporterOpportunite", name="remporter_opportunite", requirements={"id"="\d+"}, methods={"GET"})
     */

    public function remporterOpportunite(Opportunity $opportunity, EntityManagerInterface $manager): Response
    {
        $opportunity->setState('Remporté');
        $manager->flush();
        return $this->redirectToRoute('vue_opportunite',['id' => $opportunity->getId()]);
    }

    /**
     * @Route("/{id}/perdreOpportunite", name="perdre_opportunite", requirements={"id"="\d+"}, methods={"GET"})
     */

    public function perdreOpportunite( Opportunity $opportunity, EntityManagerInterface $manager): Response
    {
        $opportunity->setState('Perdu');
        $manager->flush();
        return $this->redirectToRoute('vue_opportunite',['id' => $opportunity->getId()]);
    }


    #[Route('/new/dupliquer_opportunite/{id}', name: 'dupliquer_opportunite')]
    public function dupliquerOpportunite(Opportunity $opportunity,Request $request, EntityManagerInterface $manager): Response
    {


        if($request->isMethod('POST')){
            $dupOpportunity = new Opportunity();
            $form = $this->createForm(OpportunityType::class, $dupOpportunity);
        }else{
            $form = $this->createForm(OpportunityType::class, $opportunity);
        }

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($dupOpportunity);
            $manager->flush();


            return $this->redirectToRoute('opportunites');

        }


        return $this->render('opportunite/dupliquerOpportunite.html.twig',[
            'form' => $form->createView(),
            'opportunity' => $opportunity
        ]);

    }

    #[Route('/new/dupliquer_devis/{id}', name: 'dupliquer_devis_opportunite')]
    public function dupliquerDevisOpportunite(Quotation $quotation,Request $request, EntityManagerInterface $manager): Response
    {

        $opportunity = new Opportunity();

        if($request->isMethod('POST')){

            $form = $this->createForm(OpportunityType::class, $opportunity);

        }else{
            $opportunity->setBusinessClient($quotation->getBusinessClient());
            $opportunity->setParticularClient($quotation->getParticularClient());
            $opportunity->setCompany($quotation->getCompany());
            $opportunity->setDevise($quotation->getDevise());
            $opportunity->setMontantHt($quotation->calculTotalHt());
            $form = $this->createForm(OpportunityType::class, $opportunity);
        }

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($opportunity);
            $manager->flush();


            return $this->redirectToRoute('opportunites');

        }


        return $this->render('opportunite/dupliquerOpportunite.html.twig',[
            'form' => $form->createView(),
            'opportunity' => $opportunity
        ]);

    }

    #[Route('/new/dupliquer_facture/{id}', name: 'dupliquer_facture_opportunite')]
    public function dupliquerFactureOpportunite(Bill $bill,Request $request, EntityManagerInterface $manager): Response
    {

        $opportunity = new Opportunity();

        if($request->isMethod('POST')){

            $form = $this->createForm(OpportunityType::class, $opportunity);

        }else{
            $opportunity->setBusinessClient($bill->getBusinessClient());
            $opportunity->setParticularClient($bill->getParticularClient());
            $opportunity->setCompany($bill->getCompany());
            $opportunity->setDevise($bill->getDevise());
            $opportunity->setMontantHt($bill->calculTotalHt());
            $form = $this->createForm(OpportunityType::class, $opportunity);
        }

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($opportunity);
            $manager->flush();


            return $this->redirectToRoute('opportunites');

        }


        return $this->render('opportunite/dupliquerOpportunite.html.twig',[
            'form' => $form->createView(),
            'opportunity' => $opportunity
        ]);

    }

    #[Route('/new/dupliquer_avoir/{id}', name: 'dupliquer_avoir_opportunite')]
    public function dupliquerAvoirOpportunite(BillCredit $billCredit,Request $request, EntityManagerInterface $manager): Response
    {

        $opportunity = new Opportunity();

        if($request->isMethod('POST')){

            $form = $this->createForm(OpportunityType::class, $opportunity);

        }else{
            $opportunity->setBusinessClient($billCredit->getBusinessClient());
            $opportunity->setParticularClient($billCredit->getParticularClient());
            $opportunity->setCompany($billCredit->getCompany());
            $opportunity->setDevise($billCredit->getDevise());
            $opportunity->setMontantHt($billCredit->calculTotalHt());
            $form = $this->createForm(OpportunityType::class, $opportunity);
        }

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($opportunity);
            $manager->flush();


            return $this->redirectToRoute('opportunites');

        }


        return $this->render('opportunite/dupliquerOpportunite.html.twig',[
            'form' => $form->createView(),
            'opportunity' => $opportunity
        ]);

    }

    #[Route('/new/dupliquer_factureAcompte/{id}', name: 'dupliquer_facture_acompte_opportunite')]
    public function dupliquerFactureAcompteOpportunite(Deposit $deposit,Request $request, EntityManagerInterface $manager): Response
    {

        $opportunity = new Opportunity();

        if($request->isMethod('POST')){

            $form = $this->createForm(OpportunityType::class, $opportunity);

        }else{
            $opportunity->setBusinessClient($deposit->getQuotation()->getBusinessClient());
            $opportunity->setParticularClient($deposit->getQuotation()->getParticularClient());
            $opportunity->setCompany($deposit->getQuotation()->getCompany());
            $opportunity->setMontantHt($deposit->getMontantPayer());
            $form = $this->createForm(OpportunityType::class, $opportunity);
        }

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($opportunity);
            $manager->flush();


            return $this->redirectToRoute('opportunites');

        }


        return $this->render('opportunite/dupliquerOpportunite.html.twig',[
            'form' => $form->createView(),
            'opportunity' => $opportunity
        ]);

    }









}
