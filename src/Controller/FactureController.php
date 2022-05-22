<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Bill;
use App\Entity\BillCredit;
use App\Entity\Deposit;
use App\Entity\Opportunity;
use App\Entity\Quotation;
use App\Form\BillType;
use App\Form\QuotationType;
use App\Repository\BillRepository;
use App\Repository\PreferenceGeneralRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/factures")
 */

class FactureController extends AbstractController
{

    #[Route('/', name: 'factures')]
    public function factures(BillRepository $billRepository): Response
    {
        $bills = $billRepository->findAll();
        return $this->render('facture/factures.html.twig', [
            'bills' => $bills,
        ]);
    }

    #[Route('/provisoires', name: 'factures_provisoires')]
    public function facturesProvisoires(BillRepository $billRepository): Response
    {
        $bills = $billRepository->findBy([
            'state' => 'provisoire'
        ]);
        return $this->render('facture/factures.html.twig', [
            'bills' => $bills,
        ]);
    }

    #[Route('/finalisees', name: 'factures_finalisees')]
    public function facturesFinalisees(BillRepository $billRepository): Response
    {
        $bills = $billRepository->findBy([
            'state' => 'finalisée'
        ]);
        return $this->render('facture/factures.html.twig', [
            'bills' => $bills,
        ]);
    }

    #[Route('/payees', name: 'factures_payees')]
    public function facturesPayees(BillRepository $billRepository): Response
    {
        $bills = $billRepository->findBy([
            'state' => 'payée'
        ]);
        return $this->render('facture/factures.html.twig', [
            'bills' => $bills,
        ]);
    }

    #[Route('/a_payer', name: 'factures_a_payer')]
    public function facturesAPayer(BillRepository $billRepository): Response
    {
        $bills = $billRepository->findBy([
            'state' => 'finalisée'
        ]);
        return $this->render('facture/factures.html.twig', [
            'bills' => $bills,
        ]);
    }

    /**
     * @Route("/{id}", name="vue_facture", requirements={"id"="\d+"}, methods={"GET","POST"})
     */
    public function vueFacture(Bill $bill, EntityManagerInterface $manager,PreferenceGeneralRepository $preferenceGeneralRepository): Response
    {

        return $this->render('facture/vueFacture.html.twig',[
            'bill' => $bill,
            'text_tva' => $preferenceGeneralRepository->find(1)->getTextTva()
        ]);

    }


    #[Route('/new', name: 'add_facture')]
    public function addFacture(Request $request, EntityManagerInterface $manager): Response
    {
        $bill = new Bill();
        //dump($bill);die;

        $form = $this->createForm(BillType::class, $bill);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($bill);
            $manager->flush();


            return $this->redirectToRoute('factures');

        }

        return $this->render('facture/ajoutFacture.html.twig',[
            'form' => $form->createView()
        ]);

    }



    /**
     * @Route("/{id}/edit", name="edit_facture", requirements={"id"="\d+"}, methods={"GET","POST"})
     */

    public function updateFacture(Bill $bill, Request $request, EntityManagerInterface $manager): Response
    {
        $originalArticles = new ArrayCollection();
        $originalDisbursements = new ArrayCollection();


        foreach ($bill->getArticles() as $article) {
            $originalArticles->add($article);
        }

        foreach ($bill->getDisbursements() as $disbursement) {
            $originalDisbursements->add($disbursement);
        }

        $editForm = $this->createForm(BillType::class, $bill);

        $editForm->handleRequest($request);

        if($editForm->isSubmitted() && $editForm->isValid()){

            foreach ($originalArticles as $article) {
                if (false === $bill->getArticles()->contains($article)) {

                    $manager->remove($article);

                }
            }

            foreach ($originalDisbursements as $disbursement) {
                if (false === $bill->getDisbursements()->contains($disbursement)) {

                    $manager->remove($disbursement);

                }
            }

            $bill->setLastUpdate(new \DateTime('now'));

            $manager->flush();

            return $this->redirectToRoute('factures');

        }

        return $this->render('facture/modifFacture.html.twig',[
            'form' => $editForm->createView(),
            'bill' => $bill
        ]);

    }

    #[Route('/{id}/delete', name: 'delete_facture')]
    public function deleteFacture(Bill $bill,EntityManagerInterface $manager): Response
    {

        foreach ($bill->getArticles() as $article) {
            $manager->remove($article);
        }

        foreach ($bill->getDisbursements() as $disbursement) {
            $manager->remove($disbursement);
        }

        $manager->remove($bill);
        $manager->flush();
        return $this->redirectToRoute('factures');
    }

    /**
     * @Route("/{id}/finalise", name="finaliser_facture", requirements={"id"="\d+"}, methods={"GET"})
     */

    public function finaliseFacture( Bill $bill, EntityManagerInterface $manager,BillRepository $billRepository): Response
    {

        if($billRepository->findMaxNumerotation()[1] === null){
            $bill->setNumerotation(2200001);
        }else{
            $bill->setNumerotation($billRepository->findMaxNumerotation()[1]+1);
        }
        $bill->setState('finalisée');
        $bill->setFinalizationAt(new \DateTime('now'));
        $manager->flush();
        return $this->redirectToRoute('vue_facture',['id' => $bill->getId()]);
    }

    /**
     * @Route("/{id}/payer", name="payer_facture", requirements={"id"="\d+"}, methods={"GET","POST"})
     */

    public function payerFacture( Bill $bill,Request $request, EntityManagerInterface $manager): Response
    {
        $bill->setState('payée');
        $bill->setPayedAt(new \DateTime($request->request->get('payed_date')));
        $manager->flush();
        return $this->redirectToRoute('vue_facture',['id' => $bill->getId()]);
    }

    /**
     * @Route("/{id}/annulerPaiement", name="annuler_paiement_facture", requirements={"id"="\d+"}, methods={"GET"})
     */

    public function annulePaiementFacture( Bill $bill, EntityManagerInterface $manager): Response
    {
        $bill->setState('finalisée');
        $manager->flush();
        return $this->redirectToRoute('vue_facture',['id' => $bill->getId()]);
    }

    #[Route('/new/dupliquer_facture/{id}', name: 'dupliquer_facture')]
    public function dupliquerFacture(Bill $bill,Request $request, EntityManagerInterface $manager): Response
    {


        if($request->isMethod('POST')){
            $dupBill = new Bill();
            $form = $this->createForm(BillType::class, $dupBill);
        }else{
            $form = $this->createForm(BillType::class, $bill);
        }

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($dupBill);
            $manager->flush();


            return $this->redirectToRoute('factures');

        }


        return $this->render('facture/dupliquerFacture.html.twig',[
            'form' => $form->createView(),
            'bill' => $bill
        ]);

    }



    #[Route('/new/dupliquer_devis/{id}', name: 'dupliquer_devis_facture')]
    public function dupliquerDevisFacture(Quotation $quotation,Request $request, EntityManagerInterface $manager): Response
    {

        $bill = new Bill();

        if($request->isMethod('POST')){

            $form = $this->createForm(BillType::class, $bill);

        }else{
            $bill->setBusinessClient($quotation->getBusinessClient());
            $bill->setParticularClient($quotation->getParticularClient());
            $bill->setCompany($quotation->getCompany());
            $bill->setDevise($quotation->getDevise());
            $bill->setTvaNonApplicable($quotation->getTvaNonApplicable());
            $bill->setArticles($quotation->getArticles());
            $bill->setConditionReglement($quotation->getConditionReglement());
            $bill->setModeReglement($quotation->getModeReglement());
            $bill->setInteretRetard($quotation->getInteretRetard());
            $form = $this->createForm(BillType::class, $bill);
        }

        $form->handleRequest($request);
        //dump($bill);die;
        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($bill);
            $manager->flush();


            return $this->redirectToRoute('factures');

        }


        return $this->render('facture/dupliquerFacture.html.twig',[
            'form' => $form->createView(),
            'bill' => $bill
        ]);

    }

    #[Route('/new/dupliquer_avoir/{id}', name: 'dupliquer_avoir_facture')]
    public function dupliquerAvoirFacture(BillCredit $billCredit,Request $request, EntityManagerInterface $manager): Response
    {

        $bill = new Bill();

        if($request->isMethod('POST')){

            $form = $this->createForm(BillType::class, $bill);

        }else{
            $bill->setBusinessClient($billCredit->getBusinessClient());
            $bill->setParticularClient($billCredit->getParticularClient());
            $bill->setCompany($billCredit->getCompany());
            $bill->setDevise($billCredit->getDevise());
            $bill->setTvaNonApplicable($billCredit->getTvaNonApplicable());
            $bill->setArticles($billCredit->getArticles());
            $bill->setDisbursements($billCredit->getDisbursements());
            $bill->setConditionReglement($billCredit->getConditionReglement());
            $bill->setModeReglement($billCredit->getModeReglement());
            $bill->setInteretRetard($billCredit->getInteretRetard());
            $form = $this->createForm(BillType::class, $bill);
        }

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($bill);
            $manager->flush();


            return $this->redirectToRoute('factures');

        }


        return $this->render('facture/dupliquerFacture.html.twig',[
            'form' => $form->createView(),
            'bill' => $bill
        ]);

    }

    #[Route('/new/dupliquer_factureAcompte/{id}', name: 'dupliquer_facture_acompte_facture')]
    public function dupliquerFactureAcompteFacture(Deposit $deposit,Request $request, EntityManagerInterface $manager): Response
    {

        $bill = new Bill();

        if($request->isMethod('POST')){

            $form = $this->createForm(BillType::class, $bill);

        }else{
            $bill->setBusinessClient($deposit->getQuotation()->getBusinessClient());
            $bill->setParticularClient($deposit->getQuotation()->getParticularClient());
            $bill->setCompany($deposit->getQuotation()->getCompany());
            $bill->setConditionReglement($deposit->getConditionReglement());
            $bill->setModeReglement($deposit->getModeReglement());
            $bill->setInteretRetard($deposit->getInteretRetard());
            $form = $this->createForm(BillType::class, $bill);
        }

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($bill);
            $manager->flush();


            return $this->redirectToRoute('factures');

        }


        return $this->render('facture/dupliquerFacture.html.twig',[
            'form' => $form->createView(),
            'bill' => $bill
        ]);

    }


    #[Route('/new/dupliquer_opportunite/{id}', name: 'dupliquer_opportunite_facture')]
    public function dupliquerOpportuniteDevis(Opportunity $opportunity,Request $request, EntityManagerInterface $manager): Response
    {

        $bill = new Bill();

        if($request->isMethod('POST')){

            $form = $this->createForm(BillType::class, $bill);

        }else{
            $bill->setBusinessClient($opportunity->getBusinessClient());
            $bill->setParticularClient($opportunity->getParticularClient());
            $bill->setCompany($opportunity->getCompany());
            $bill->setDevise($opportunity->getDevise());

            $bill->addArticle((new Article())->setPrixHt($opportunity->getMontantHt()));

            $form = $this->createForm(BillType::class, $bill);
        }

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($bill);
            $manager->flush();


            return $this->redirectToRoute('factures');

        }


        return $this->render('facture/dupliquerFacture.html.twig',[
            'form' => $form->createView(),
            'bill' => $bill
        ]);

    }





}
