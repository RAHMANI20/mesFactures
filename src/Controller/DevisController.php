<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Bill;
use App\Entity\BillCredit;
use App\Entity\Company;
use App\Entity\Deposit;
use App\Entity\Opportunity;
use App\Entity\Quotation;
use App\Form\ArticleType;
use App\Form\BillType;
use App\Form\CompanyType;
use App\Form\QuotationType;
use App\Repository\PreferenceGeneralRepository;
use App\Repository\QuotationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/devis")
 */

class DevisController extends AbstractController
{
    #[Route('/', name: 'devis')]
    public function devis(QuotationRepository $quotationRepository): Response
    {
        $quotations = $quotationRepository->findAll();
        return $this->render('devis/devis.html.twig', [
            'controller_name' => 'MainController',
            'quotations' => $quotations,
        ]);
    }

    #[Route('/provisoires', name: 'devis_provisoires')]
    public function devisProvisoires(QuotationRepository $quotationRepository): Response
    {
        $quotations = $quotationRepository->findBy([
            'state' => 'provisoire'
        ]);
        return $this->render('devis/devis.html.twig', [
            'controller_name' => 'MainController',
            'quotations' => $quotations,
        ]);
    }

    #[Route('/finalises', name: 'devis_finalises')]
    public function devisFinalises(QuotationRepository $quotationRepository): Response
    {
        $quotations = $quotationRepository->findBy([
            'state' => 'finalise'
        ]);
        return $this->render('devis/devis.html.twig', [
            'controller_name' => 'MainController',
            'quotations' => $quotations,
        ]);
    }

    #[Route('/refuses', name: 'devis_refuses')]
    public function devisRefuses(QuotationRepository $quotationRepository): Response
    {
        $quotations = $quotationRepository->findBy([
            'state' => 'refuse'
        ]);
        return $this->render('devis/devis.html.twig', [
            'controller_name' => 'MainController',
            'quotations' => $quotations,
        ]);
    }

    #[Route('/signes', name: 'devis_signes')]
    public function devisSignes(QuotationRepository $quotationRepository): Response
    {
        $quotations = $quotationRepository->findBy([
            'state' => 'signe'
        ]);
        return $this->render('devis/devis.html.twig', [
            'controller_name' => 'MainController',
            'quotations' => $quotations,
        ]);
    }

    /**
     * @Route("/{id}", name="vue_devis", requirements={"id"="\d+"}, methods={"GET","POST"})
     */
    public function vueDevis(Quotation $quotation, EntityManagerInterface $manager,PreferenceGeneralRepository $preferenceGeneralRepository): Response
    {

        return $this->render('devis/vueDevis.html.twig',[
            'quotation' => $quotation,
            'text_tva' => $preferenceGeneralRepository->find(1)->getTextTva()
        ]);

    }



    #[Route('/new', name: 'add_devis')]
    public function addDevis(Request $request, EntityManagerInterface $manager): Response
    {
        //dump($request);die;
        $quotation = new Quotation();

        $form = $this->createForm(QuotationType::class, $quotation);

        $form->handleRequest($request);
        //dump($quotation);die;
        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($quotation);
            $manager->flush();


            return $this->redirectToRoute('devis');

        }

        return $this->render('devis/ajoutDevis.html.twig',[
            'form' => $form->createView()
        ]);

    }


    /**
     * @Route("/{id}/edit", name="edit_devis", requirements={"id"="\d+"}, methods={"GET","POST"})
     */

    public function updateDevis( Quotation $quotation, Request $request, EntityManagerInterface $manager): Response
    {
        $originalArticles = new ArrayCollection();

        // Create an ArrayCollection of the current Article objects in the database
        foreach ($quotation->getArticles() as $article) {
            $originalArticles->add($article);
        }

        $editForm = $this->createForm(QuotationType::class, $quotation);

        $editForm->handleRequest($request);

        if($editForm->isSubmitted() && $editForm->isValid()){

            foreach ($originalArticles as $article) {
                if (false === $quotation->getArticles()->contains($article)) {

                    $manager->remove($article);

                }
            }

            $quotation->setLastUpdate(new \DateTime('now'));

            $manager->flush();

            return $this->redirectToRoute('devis');

        }

        return $this->render('devis/modifDevis.html.twig',[
            'form' => $editForm->createView(),
            'quotation' => $quotation
        ]);

    }

    #[Route('/{id}/delete', name: 'delete_devis')]
    public function deleteDevis(Quotation $quotation,EntityManagerInterface $manager): Response
    {

        foreach ($quotation->getArticles() as $article) {
            $manager->remove($article);
        }

        $manager->remove($quotation);
        $manager->flush();
        return $this->redirectToRoute('devis');
    }

    /**
     * @Route("/{id}/finalise", name="finaliser_devis", requirements={"id"="\d+"}, methods={"GET"})
     */

    public function finaliseDevis( Quotation $quotation, EntityManagerInterface $manager,QuotationRepository $quotationRepository): Response
    {
        //dump($quotationRepository->findMaxNumerotation()[1]);die;
        if($quotationRepository->findMaxNumerotation()[1] === null){
            $quotation->setNumerotation(2200001);
        }else{
            $quotation->setNumerotation($quotationRepository->findMaxNumerotation()[1]+1);
        }
        $quotation->setState('finalisé');
        $quotation->setFinalizationAt(new \DateTime('now'));
        $manager->flush();
        return $this->redirectToRoute('vue_devis',['id' => $quotation->getId()]);
    }

    /**
     * @Route("/{id}/signe", name="signer_devis", requirements={"id"="\d+"}, methods={"GET","POST"})
     */

    public function signeDevis( Quotation $quotation,Request $request, EntityManagerInterface $manager): Response
    {
        //dump($request->request->get('signed_date'));die;
        $quotation->setState('signé');
        $quotation->setSignedAt(new \DateTime($request->request->get('signed_date')));
        $manager->flush();
        return $this->redirectToRoute('vue_devis',['id' => $quotation->getId()]);
    }

    /**
     * @Route("/{id}/annulerSignature", name="annuler_signature_devis", requirements={"id"="\d+"}, methods={"GET"})
     */

    public function annuleSignatureDevis( Quotation $quotation, EntityManagerInterface $manager): Response
    {
        $quotation->setState('finalisé');
        $manager->flush();
        return $this->redirectToRoute('vue_devis',['id' => $quotation->getId()]);
    }

    /**
     * @Route("/{id}/refuse", name="refuser_devis", requirements={"id"="\d+"}, methods={"GET"})
     */

    public function refuseDevis( Quotation $quotation, EntityManagerInterface $manager): Response
    {
        $quotation->setState('refusé');
        $manager->flush();
        return $this->redirectToRoute('vue_devis',['id' => $quotation->getId()]);
    }

    /**
     * @Route("/{id}/annulerRefus", name="annuler_refus_devis", requirements={"id"="\d+"}, methods={"GET"})
     */

    public function annuleRefusDevis( Quotation $quotation, EntityManagerInterface $manager): Response
    {
        $quotation->setState('finalisé');
        $manager->flush();
        return $this->redirectToRoute('vue_devis',['id' => $quotation->getId()]);
    }


    #[Route('/new/dupliquer_devis/{id}', name: 'dupliquer_devis')]
    public function dupliquerDevis(Quotation $quotation,Request $request, EntityManagerInterface $manager): Response
    {


        if($request->isMethod('POST')){
            $dupQuotation = new Quotation();
            $form = $this->createForm(QuotationType::class, $dupQuotation);
        }else{
            $form = $this->createForm(QuotationType::class, $quotation);
        }

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($dupQuotation);
            $manager->flush();


            return $this->redirectToRoute('devis');

        }


        return $this->render('devis/dupliquerDevis.html.twig',[
            'form' => $form->createView(),
            'quotation' => $quotation
        ]);

    }


    #[Route('/new/dupliquer_facture/{id}', name: 'dupliquer_facture_devis')]
    public function dupliquerFactureDevis(Bill $bill,Request $request, EntityManagerInterface $manager): Response
    {

        $quotation = new Quotation();

        if($request->isMethod('POST')){

            $form = $this->createForm(QuotationType::class, $quotation);

        }else{
            $quotation->setBusinessClient($bill->getBusinessClient());
            $quotation->setParticularClient($bill->getParticularClient());
            $quotation->setCompany($bill->getCompany());
            $quotation->setDevise($bill->getDevise());
            $quotation->setTvaNonApplicable($bill->getTvaNonApplicable());
            $quotation->setArticles($bill->getArticles());
            $quotation->setConditionReglement($bill->getConditionReglement());
            $quotation->setModeReglement($bill->getModeReglement());
            $quotation->setInteretRetard($bill->getInteretRetard());
            $form = $this->createForm(QuotationType::class, $quotation);
        }

        $form->handleRequest($request);
        //dump($bill);die;
        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($quotation);
            $manager->flush();


            return $this->redirectToRoute('devis');

        }


        return $this->render('devis/dupliquerDevis.html.twig',[
            'form' => $form->createView(),
            'quotation' => $quotation
        ]);

    }

    #[Route('/new/dupliquer_avoir/{id}', name: 'dupliquer_avoir_devis')]
    public function dupliquerAvoirDevis(BillCredit $billCredit,Request $request, EntityManagerInterface $manager): Response
    {

        $quotation = new Quotation();

        if($request->isMethod('POST')){

            $form = $this->createForm(QuotationType::class, $quotation);

        }else{
            $quotation->setBusinessClient($billCredit->getBusinessClient());
            $quotation->setParticularClient($billCredit->getParticularClient());
            $quotation->setCompany($billCredit->getCompany());
            $quotation->setDevise($billCredit->getDevise());
            $quotation->setTvaNonApplicable($billCredit->getTvaNonApplicable());
            $quotation->setArticles($billCredit->getArticles());
            $quotation->setConditionReglement($billCredit->getConditionReglement());
            $quotation->setModeReglement($billCredit->getModeReglement());
            $quotation->setInteretRetard($billCredit->getInteretRetard());
            $form = $this->createForm(QuotationType::class, $quotation);
        }

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($quotation);
            $manager->flush();


            return $this->redirectToRoute('devis');

        }


        return $this->render('devis/dupliquerDevis.html.twig',[
            'form' => $form->createView(),
            'quotation' => $quotation
        ]);

    }

    #[Route('/new/dupliquer_factureAcompte/{id}', name: 'dupliquer_facture_acompte_devis')]
    public function dupliquerFactureAcompteDevis(Deposit $deposit,Request $request, EntityManagerInterface $manager): Response
    {

        $quotation = new Quotation();

        if($request->isMethod('POST')){

            $form = $this->createForm(QuotationType::class, $quotation);

        }else{
            $quotation->setBusinessClient($deposit->getQuotation()->getBusinessClient());
            $quotation->setParticularClient($deposit->getQuotation()->getParticularClient());
            $quotation->setCompany($deposit->getQuotation()->getCompany());
            $quotation->setConditionReglement($deposit->getConditionReglement());
            $quotation->setModeReglement($deposit->getModeReglement());
            $quotation->setInteretRetard($deposit->getInteretRetard());
            $form = $this->createForm(QuotationType::class, $quotation);
        }

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($quotation);
            $manager->flush();


            return $this->redirectToRoute('devis');

        }


        return $this->render('devis/dupliquerDevis.html.twig',[
            'form' => $form->createView(),
            'quotation' => $quotation
        ]);

    }


    #[Route('/new/dupliquer_opportunite/{id}', name: 'dupliquer_opportunite_devis')]
    public function dupliquerOpportuniteDevis(Opportunity $opportunity,Request $request, EntityManagerInterface $manager): Response
    {

        $quotation = new Quotation();

        if($request->isMethod('POST')){

            $form = $this->createForm(QuotationType::class, $quotation);

        }else{
            $quotation->setBusinessClient($opportunity->getBusinessClient());
            $quotation->setParticularClient($opportunity->getParticularClient());
            $quotation->setCompany($opportunity->getCompany());
            $quotation->setDevise($opportunity->getDevise());

            $quotation->addArticle((new Article())->setPrixHt($opportunity->getMontantHt()));

            $form = $this->createForm(QuotationType::class, $quotation);
        }

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($quotation);
            $manager->flush();


            return $this->redirectToRoute('devis');

        }


        return $this->render('devis/dupliquerDevis.html.twig',[
            'form' => $form->createView(),
            'quotation' => $quotation
        ]);

    }













}
