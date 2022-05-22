<?php

namespace App\Controller;

use App\Entity\BillCredit;
use App\Form\BillCreditType;
use App\Repository\BillCreditRepository;
use App\Repository\PreferenceGeneralRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/avoirs")
 */

class AvoirController extends AbstractController
{

    #[Route('/', name: 'avoirs')]
    public function avoirs(BillCreditRepository $billCreditRepository): Response
    {
        $billCredits = $billCreditRepository->findAll();
        return $this->render('avoir/avoirs.html.twig', [
            'billCredits' => $billCredits,
        ]);
    }

    #[Route('/provisoires', name: 'avoirs_provisoires')]
    public function avoirsProvisoires(BillCreditRepository $billCreditRepository): Response
    {
        $billCredits = $billCreditRepository->findBy([
            'state' => 'provisoire'
        ]);
        return $this->render('avoir/avoirs.html.twig', [
            'billCredits' => $billCredits,
        ]);
    }

    #[Route('/finalises', name: 'avoirs_finalises')]
    public function avoirsFinalises(BillCreditRepository $billCreditRepository): Response
    {
        $billCredits = $billCreditRepository->findBy([
            'state' => 'finalisé'
        ]);
        return $this->render('avoir/avoirs.html.twig', [
            'billCredits' => $billCredits,
        ]);
    }

    #[Route('/rembourses', name: 'avoirs_rembourses')]
    public function avoirsRembourses(BillCreditRepository $billCreditRepository): Response
    {
        $billCredits = $billCreditRepository->findBy([
            'state' => 'remboursé'
        ]);
        return $this->render('avoir/avoirs.html.twig', [
            'billCredits' => $billCredits,
        ]);

    }

    /**
     * @Route("/{id}", name="vue_avoir", requirements={"id"="\d+"}, methods={"GET","POST"})
     */
    public function vueAvoir(BillCredit $billCredit, EntityManagerInterface $manager,PreferenceGeneralRepository $preferenceGeneralRepository): Response
    {

        return $this->render('avoir/vueAvoir.html.twig',[
            'billCredit' => $billCredit,
            'text_tva' => $preferenceGeneralRepository->find(1)->getTextTva()
        ]);

    }


    #[Route('/new', name: 'add_avoir')]
    public function addAvoir(Request $request, EntityManagerInterface $manager): Response
    {
        $billCredit = new BillCredit();

        $form = $this->createForm(BillCreditType::class, $billCredit);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($billCredit);
            $manager->flush();


            return $this->redirectToRoute('avoirs');

        }

        return $this->render('avoir/ajoutAvoir.html.twig',[
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/{id}/edit", name="edit_avoir", requirements={"id"="\d+"}, methods={"GET","POST"})
     */

    public function updateAvoir(BillCredit $billCredit, Request $request, EntityManagerInterface $manager): Response
    {
        $originalArticles = new ArrayCollection();
        $originalDisbursements = new ArrayCollection();


        foreach ($billCredit->getArticles() as $article) {
            $originalArticles->add($article);
        }

        foreach ($billCredit->getDisbursements() as $disbursement) {
            $originalDisbursements->add($disbursement);
        }

        $editForm = $this->createForm(BillCreditType::class, $billCredit);

        $editForm->handleRequest($request);

        if($editForm->isSubmitted() && $editForm->isValid()){

            foreach ($originalArticles as $article) {
                if (false === $billCredit->getArticles()->contains($article)) {

                    $manager->remove($article);

                }
            }

            foreach ($originalDisbursements as $disbursement) {
                if (false === $billCredit->getDisbursements()->contains($disbursement)) {

                    $manager->remove($disbursement);

                }
            }

            $billCredit->setLastUpdate(new \DateTime('now'));

            $manager->flush();

            return $this->redirectToRoute('avoirs');

        }

        return $this->render('avoir/modifAvoir.html.twig',[
            'form' => $editForm->createView(),
            'billCredit' => $billCredit
        ]);

    }

    #[Route('/{id}/delete', name: 'delete_avoir')]
    public function deleteAvoir(BillCredit $billCredit,EntityManagerInterface $manager): Response
    {

        foreach ($billCredit->getArticles() as $article) {
            $manager->remove($article);
        }

        foreach ($billCredit->getDisbursements() as $disbursement) {
            $manager->remove($disbursement);
        }

        $manager->remove($billCredit);
        $manager->flush();
        return $this->redirectToRoute('avoirs');
    }

    /**
     * @Route("/{id}/finalise", name="finaliser_avoir", requirements={"id"="\d+"}, methods={"GET"})
     */

    public function finaliseAvoir( BillCredit $billCredit, EntityManagerInterface $manager,BillCreditRepository $billCreditRepository): Response
    {

        if($billCreditRepository->findMaxNumerotation()[1] === null){
            $billCredit->setNumerotation(2200001);
        }else{
            $billCredit->setNumerotation($billCreditRepository->findMaxNumerotation()[1]+1);
        }
        $billCredit->setState('finalisé');
        $billCredit->setFinalizationAt(new \DateTime('now'));
        $manager->flush();
        return $this->redirectToRoute('vue_avoir',['id' => $billCredit->getId()]);
    }

    /**
     * @Route("/{id}/rembourser", name="rembourser_avoir", requirements={"id"="\d+"}, methods={"GET","POST"})
     */

    public function rembourserAvoir( BillCredit $billCredit,Request $request, EntityManagerInterface $manager): Response
    {
        $billCredit->setState('remboursé');
        $billCredit->setRefundedAt(new \DateTime($request->request->get('refunded_date')));
        $manager->flush();
        return $this->redirectToRoute('vue_avoir',['id' => $billCredit->getId()]);
    }

    /**
     * @Route("/{id}/annulerRemboursement", name="annuler_remboursement_avoir", requirements={"id"="\d+"}, methods={"GET"})
     */

    public function annuleRemboursementAvoir( BillCredit $billCredit, EntityManagerInterface $manager): Response
    {
        $billCredit->setState('finalisé');
        $manager->flush();
        return $this->redirectToRoute('vue_avoir',['id' => $billCredit->getId()]);
    }

}
