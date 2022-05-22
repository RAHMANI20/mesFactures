<?php

namespace App\Controller;

use App\Entity\BusinessClient;
use App\Entity\Company;
use App\Entity\ParticularClient;
use App\Form\BusinessClientType;
use App\Form\CompanyType;
use App\Form\ParticularClientType;
use App\Repository\BusinessClientRepository;
use App\Repository\CompanyRepository;
use App\Repository\ParticularClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'main')]
    public function index(): Response
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    #[Route('/dashboard', name: 'dashboard')]
    public function dashboard(): Response
    {
        return $this->render('default/dashboard.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }




}
