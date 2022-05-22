<?php

namespace App\Controller;

use App\Entity\AccountDeletion;
use App\Entity\BankAccount;
use App\Entity\PreferenceQuotation;
use App\Entity\TypeArticle;
use App\Form\AccountDeletionType;
use App\Form\BankAccountType;
use App\Form\EditProfileType;
use App\Form\PreferenceBillCreditType;
use App\Form\PreferenceBillType;
use App\Form\PreferenceDepositType;
use App\Form\PreferenceGeneralType;
use App\Form\PreferenceQuotationType;
use App\Form\RegistrationFormType;
use App\Form\TypeArticleType;
use App\Repository\BankAccountRepository;
use App\Repository\PreferenceBillCreditRepository;
use App\Repository\PreferenceBillRepository;
use App\Repository\PreferenceDepositRepository;
use App\Repository\PreferenceGeneralRepository;
use App\Repository\PreferenceQuotationRepository;
use App\Repository\TypeArticleRepository;
use App\Repository\UsersRepository;
use App\Service\VerificationUtilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/parametres")
 */

class ParametresController extends AbstractController
{
    #[Route('/', name: 'parametres')]
    public function parametres(): Response
    {
        return $this->render('parametres/parametres.html.twig', [
            'controller_name' => 'ParametresController',
        ]);
    }

    #[Route('/comptes_bancaires', name: 'comptes_bancaires')]
    public function comptesBancaires(BankAccountRepository $bankAccountRepository): Response
    {
        $bankAccounts = $bankAccountRepository->findAll();

        return $this->render('parametres/comptesBancaires.html.twig', [
            'controller_name' => 'ParametresController',
            'bankAccounts' => $bankAccounts
        ]);
    }

    /**
     * @Route("/comptes_bancaires/{id}", name="vue_compte_bancaire", requirements={"id"="\d+"}, methods={"GET","POST"})
     */
    public function vueCompteBancaire(BankAccount $bankAccount, EntityManagerInterface $manager): Response
    {

        return $this->render('parametres/vueCompteBancaire.html.twig',[
            'bankAccount' => $bankAccount,
        ]);

    }
    /**
     * @Route("/comptes_bancaires/new", name="add_compte_bancaire")
     */

    public function addCompteBancaire(Request $request, EntityManagerInterface $manager): Response
    {
        $bankAccount = new BankAccount();

        $form = $this->createForm(BankAccountType::class, $bankAccount);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($bankAccount);
            $manager->flush();


            return $this->redirectToRoute('comptes_bancaires');

        }

        return $this->render('parametres/ajoutCompteBancaire.html.twig',[
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/comptes_bancaires/{id}/edit", name="edit_compte_bancaire", requirements={"id"="\d+"}, methods={"GET","POST"})
     */

    public function updateCompteBancaire(BankAccount $bankAccount, Request $request, EntityManagerInterface $manager): Response
    {

        $form = $this->createForm(BankAccountType::class, $bankAccount);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->flush();

            return $this->redirectToRoute('comptes_bancaires');

        }

        return $this->render('parametres/modifCompteBancaire.html.twig',[
            'form' => $form->createView(),
            'bankAccount' => $bankAccount
        ]);

    }


    #[Route('/comptes_bancaires/{id}/delete', name: 'delete_compte_bancaire')]
    public function deleteCompteBancaire(BankAccount $bankAccount,EntityManagerInterface $manager): Response
    {
        $manager->remove($bankAccount);
        $manager->flush();
        return $this->redirectToRoute('comptes_bancaires');
    }

    /**
     * @Route("/utilisateur_informations", name="utilisateur_infos", requirements={"id"="\d+"}, methods={"GET","POST"})
     */

    public function utilisateurInfos(Request $request, EntityManagerInterface $manager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(EditProfileType::class, $user);

        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){

            $manager->flush();
            $this->addFlash('message','Vos coordonnées ont été mises à jour.');
            return $this->redirectToRoute('utilisateur_infos');

        }

        return $this->render('parametres/modifUtilisateurInfo.html.twig',[
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/utilisateur", name="utilisateur", requirements={"id"="\d+"}, methods={"GET","POST"})
     */

    public function utilisateur(Request $request, EntityManagerInterface $manager,VerificationUtilisateur $verificationUtilisateur, UserPasswordHasherInterface $userPasswordHasher): Response
    {

        $user = $this->getUser();

        if($request->isMethod('POST')){

            $email = $request->request->get('email');
            $currentPassword = $request->request->get('currentPassword');
            $newPassword = $request->request->get('newPassword');
            $confirmNewPassword = $request->request->get('confirmNewPassword');


            if($verificationUtilisateur->userIsValide($email,$user->getPassword(),$currentPassword,$newPassword,$confirmNewPassword)){
                if($newPassword !== ""){
                    $user->setPassword($userPasswordHasher->hashPassword($user,$newPassword));
                }
                $user->setEmail($email);
                $manager->flush();
                $this->addFlash('message','Votre compte a été modifié avec succès.');

            }

            return $this->render('parametres/modifUtilisateur.html.twig',[
                'email' => $email,
            ]);

        }else{

            return $this->render('parametres/modifUtilisateur.html.twig',[
                'email' => $user->getEmail(),
            ]);
        }

    }

    #[Route('/supprimer_compte', name: 'delete_account')]
    public function deleteDevis(Request $request,EntityManagerInterface $manager): Response
    {

        $user = $this->getUser();

        $accountDeletion = new AccountDeletion();

        $form = $this->createForm(AccountDeletionType::class, $accountDeletion);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            if(password_verify($form->get('password')->getData(),$user->getPassword()) === true){
                $accountDeletion->setEmail($user->getEmail());
                $manager->persist($accountDeletion);
                $manager->remove($user);
                $manager->flush();
                $session = new Session();
                $session->invalidate();
                return $this->redirectToRoute('app_logout');
            }else{
                $this->addFlash('passwordError','n\'est pas valide');
            }

        }

        return $this->render('parametres/supprimerCompte.html.twig',[
            'form' => $form->createView(),
        ]);


    }



    #[Route('/types_article', name: 'types_article')]
    public function typesArticle(TypeArticleRepository $typeArticleRepository): Response
    {
        $types = $typeArticleRepository->findBy([],[
            'nom' => 'ASC'
        ]);

        return $this->render('parametres/types.html.twig', [
            'controller_name' => 'ParametresController',
            'types' => $types
        ]);
    }

    /**
     * @Route("/types_article/new", name="add_type_article")
     */

    public function addTypeArticle(Request $request, EntityManagerInterface $manager): Response
    {
        $typeArticle = new TypeArticle();

        $form = $this->createForm(TypeArticleType::class, $typeArticle);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $typeArticle->setState('new');
            $manager->persist($typeArticle);
            $manager->flush();

            return $this->redirectToRoute('types_article');

        }

        return $this->render('parametres/ajoutType.html.twig',[
            'form' => $form->createView()
        ]);

    }

    #[Route('/types_article/{id}/delete', name: 'delete_type_article')]
    public function deleteTypeArticle(TypeArticle $typeArticle,EntityManagerInterface $manager): Response
    {
        $manager->remove($typeArticle);
        $manager->flush();
        return $this->redirectToRoute('types_article');

    }

    /**
     * @Route("/preferences/generales", name="preferences_generales")
     */

    public function preferencesGenerales(PreferenceGeneralRepository $preferenceGeneralRepository,Request $request, EntityManagerInterface $manager): Response
    {
        $preferenceGeneral = $preferenceGeneralRepository->find(1);

        $form = $this->createForm(PreferenceGeneralType::class, $preferenceGeneral);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->flush();

            return $this->redirectToRoute('preferences_generales');

        }

        return $this->render('parametres/preferencesgenerales.html.twig',[
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/preferences/devis", name="preferences_devis")
     */

    public function preferencesDevis(PreferenceQuotationRepository $preferenceQuotationRepository,Request $request, EntityManagerInterface $manager): Response
    {
        $preferenceQuotation = $preferenceQuotationRepository->find(1);

        $form = $this->createForm(PreferenceQuotationType::class, $preferenceQuotation);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->flush();

            return $this->redirectToRoute('preferences_devis');

        }

        return $this->render('parametres/preferencesDevis.html.twig',[
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/preferences/facture", name="preferences_facture")
     */

    public function preferencesFacture(PreferenceBillRepository $preferenceBillRepository,Request $request, EntityManagerInterface $manager): Response
    {
        $preferenceBill = $preferenceBillRepository->find(1);

        $form = $this->createForm(PreferenceBillType::class, $preferenceBill);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->flush();

            return $this->redirectToRoute('preferences_facture');

        }

        return $this->render('parametres/preferencesFacture.html.twig',[
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/preferences/avoir", name="preferences_avoir")
     */

    public function preferencesAvoir(PreferenceBillCreditRepository $preferenceBillCreditRepository,Request $request, EntityManagerInterface $manager): Response
    {
        $preferenceBillCredit = $preferenceBillCreditRepository->find(1);

        $form = $this->createForm(PreferenceBillCreditType::class, $preferenceBillCredit);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->flush();

            return $this->redirectToRoute('preferences_avoir');

        }

        return $this->render('parametres/preferencesAvoir.html.twig',[
            'form' => $form->createView()
        ]);

    }


    /**
     * @Route("/preferences/FactureAcompte", name="preferences_facture_acompte")
     */

    public function preferencesFactureAcompte(PreferenceDepositRepository $preferenceDepositRepository,Request $request, EntityManagerInterface $manager): Response
    {
        $preferenceDeposit = $preferenceDepositRepository->find(1);

        $form = $this->createForm(PreferenceDepositType::class, $preferenceDeposit);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->flush();

            return $this->redirectToRoute('preferences_facture_acompte');

        }

        return $this->render('parametres/preferencesFactureAcompte.html.twig',[
            'form' => $form->createView()
        ]);

    }




}
