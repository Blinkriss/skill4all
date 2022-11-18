<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarCategoryController extends AbstractController
{
    /**
     * @Route("/car/category", name="app_car_category")
     */
    public function index(): Response
    {
        return $this->render('car_category/index.html.twig', [
            'controller_name' => 'CarCategoryController',
        ]);
    }
}
