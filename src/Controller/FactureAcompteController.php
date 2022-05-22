<?php

namespace App\Controller;

use App\Entity\Deposit;
use App\Form\DepositType;
use App\Repository\DepositRepository;
use App\Repository\PreferenceGeneralRepository;
use App\Service\VerificationDeposit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/factures_acompte")
 */


class FactureAcompteController extends AbstractController
{

    #[Route('/', name: 'factures_acompte')]
    public function facturesAcompte(DepositRepository $depositRepository): Response
    {
        $deposits = $depositRepository->findAll();
        return $this->render('facture_acompte/facturesAcompte.html.twig', [
            'deposits' => $deposits,
        ]);
    }

    #[Route('/provisoires', name: 'factures_acompte_provisoires')]
    public function facturesAcompteProvisoires( DepositRepository $depositRepository): Response
    {
        $deposits = $depositRepository->findBy([
            'state' => 'provisoire'
        ]);
        return $this->render('facture_acompte/facturesAcompte.html.twig', [
            'deposits' => $deposits,
        ]);
    }

    #[Route('/finalisees', name: 'factures_acompte_finalisees')]
    public function facturesAcompteFinalisees(DepositRepository $depositRepository): Response
    {
        $deposits = $depositRepository->findBy([
            'state' => 'finalisée'
        ]);
        return $this->render('facture_acompte/facturesAcompte.html.twig', [
            'deposits' => $deposits,
        ]);
    }

    #[Route('/payees', name: 'factures_acompte_payees')]
    public function facturesAcomptePayees(DepositRepository $depositRepository): Response
    {
        $deposits = $depositRepository->findBy([
            'state' => 'payée'
        ]);
        return $this->render('facture_acompte/facturesAcompte.html.twig', [
            'deposits' => $deposits,
        ]);
    }

    #[Route('/a_payer', name: 'factures_acompte_a_payer')]
    public function facturesAcompteAPayer(DepositRepository $depositRepository): Response
    {
        $deposits = $depositRepository->findBy([
            'state' => 'finalisée'
        ]);
        return $this->render('facture_acompte/facturesAcompte.html.twig', [
            'deposits' => $deposits,
        ]);
    }

    /**
     * @Route("/{id}", name="vue_facture_acompte", requirements={"id"="\d+"}, methods={"GET","POST"})
     */
    public function vueFactureAcompte(Deposit $deposit, EntityManagerInterface $manager): Response
    {

        return $this->render('facture_acompte/vueFactureAcompte.html.twig',[
            'deposit' => $deposit,
        ]);

    }

    #[Route('/new', name: 'add_facture_acompte')]
    public function addFactureAcompte(Request $request, EntityManagerInterface $manager,VerificationDeposit $verificationDeposit): Response
    {

        $deposit = new Deposit();

        $form = $this->createForm(DepositType::class, $deposit);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            if($verificationDeposit->depositIsValid($deposit)){
                $manager->persist($deposit);
                $manager->flush();
                return $this->redirectToRoute('factures_acompte');
            }else{
                $this->addFlash('error', 'Cet acompte ne peut dépasser '.$verificationDeposit->calculReste($deposit).'€');
            }


        }

        return $this->render('facture_acompte/ajoutFactureAcompte.html.twig',[
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/{id}/edit", name="edit_facture_acompte", requirements={"id"="\d+"}, methods={"GET","POST"})
     */

    public function updateFactureAcompte( Deposit $deposit, Request $request, EntityManagerInterface $manager,VerificationDeposit $verificationDeposit): Response
    {
        $form = $this->createForm(DepositType::class, $deposit);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            if($verificationDeposit->depositIsValid($deposit)){
                $manager->flush();
                return $this->redirectToRoute('factures_acompte');
            }else{
                $this->addFlash('error', 'Cet acompte ne peut dépasser '.$verificationDeposit->calculReste($deposit).'€');
            }

        }

        return $this->render('facture_acompte/modifFactureAcompte.html.twig',[
            'form' => $form->createView(),
            'deposit' => $deposit
        ]);

    }


    #[Route('/{id}/delete', name: 'delete_facture_acompte')]
    public function deleteFactureAcompte(Deposit $deposit,EntityManagerInterface $manager): Response
    {

        $manager->remove($deposit);
        $manager->flush();
        return $this->redirectToRoute('factures_acompte');

    }

    /**
     * @Route("/{id}/finalise", name="finaliser_facture_acompte", requirements={"id"="\d+"}, methods={"GET"})
     */

    public function finaliseFactureAcompte( Deposit $deposit, EntityManagerInterface $manager,DepositRepository $depositRepository): Response
    {

        if($depositRepository->findMaxNumerotation()[1] === null){
            $deposit->setNumerotation(2200001);
        }else{
            $deposit->setNumerotation($depositRepository->findMaxNumerotation()[1]+1);
        }
        $deposit->setState('finalisée');
        $deposit->setFinalizationAt(new \DateTime('now'));
        $manager->flush();
        return $this->redirectToRoute('vue_facture_acompte',['id' => $deposit->getId()]);
    }

    /**
     * @Route("/{id}/payer", name="payer_facture_acompte", requirements={"id"="\d+"}, methods={"GET","POST"})
     */

    public function payerFactureAcompte( Deposit $deposit,Request $request, EntityManagerInterface $manager): Response
    {
        $deposit->setState('payée');
        $deposit->setPayedAt(new \DateTime($request->request->get('payed_date')));
        $manager->flush();
        return $this->redirectToRoute('vue_facture_acompte',['id' => $deposit->getId()]);
    }

    /**
     * @Route("/{id}/annulerPaiement", name="annuler_paiement_facture_acompte", requirements={"id"="\d+"}, methods={"GET"})
     */

    public function annulePaiementFactureAcompte( Deposit $deposit, EntityManagerInterface $manager): Response
    {
        $deposit->setState('finalisée');
        $manager->flush();
        return $this->redirectToRoute('vue_facture_acompte',['id' => $deposit->getId()]);
    }



}
