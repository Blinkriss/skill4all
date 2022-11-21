<?php

namespace App\Controller;

use App\Entity\CarSearch;
use App\Form\CarSearchType;
use App\Repository\CarRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function home(Request $request): Response
    {
        $carSearch = new CarSearch;

        $form = $this->createForm(CarSearchType::class, $carSearch);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('car-search', ['name' => $carSearch->getName()]);
        } else {
            return $this->render('home/homepage.html.twig', [
                'form' => $form->createView(),
                'controller_name' => 'HomeController',
            ]);
        }
    }
}
