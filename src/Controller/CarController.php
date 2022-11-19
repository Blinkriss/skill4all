<?php

namespace App\Controller;

use App\Repository\CarRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CarCategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/car", name="car-")
 */
class CarController extends AbstractController
{
    /**
     * @Route("", name="browse", methods={"GET"})
     */
    public function browse(CarRepository $carRepository): Response
    {
        return $this->render('car/browse.html.twig', [
            'cars' => $carRepository->findAll(),
        ]);
    }

    /**
     * @Route("/list/{id}", name="list", requirements={"id":"\d+"})
     */
    public function browseByCategory(CarCategoryRepository $carCategoryRepository, EntityManagerInterface $em, int $id)
    {
        $categories = $carCategoryRepository->findAll();

        $query = $em->createQuery(
            'SELECT c FROM App\Entity\Car c
            JOIN c.carCategory cc
            WHERE cc.id = ' . $id,
        );

        $cars = $query->getResult();

        return $this->render('car/list.html.twig', [
            'categories' => $categories,
            'cars' => $cars,
        ]);
    }
}
