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
    public function home(Request $request, CarRepository $carRepository, PaginatorInterface $paginator): Response
    {
        $carSearch = new CarSearch();
        $cars = [];

        $form = $this->createForm(CarSearchType::class, $carSearch);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $name = $carSearch->getName();
            $data = $carRepository->findBy(['name' => $name]);

            $cars = $paginator->paginate(
                $data,
                $request->query->getInt('page', 1),
                20
            );
            return $this->render('car/search.html.twig', [
                'cars' => $cars
            ]);
        } else {
            return $this->render('home/homepage.html.twig', [
                'form' => $form->createView(),
                'controller_name' => 'HomeController',
            ]);
        }
    }
}
