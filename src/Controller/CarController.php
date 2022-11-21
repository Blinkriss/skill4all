<?php

namespace App\Controller;

use App\Entity\CarSearch;
use App\Form\CarSearchType;
use App\Repository\CarRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CarCategoryRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
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
    public function browse(CarRepository $carRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $data = $carRepository->findAll();
        $cars = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            20
        );
        return $this->render('car/browse.html.twig', [
            'cars' => $cars,
        ]);
    }

    /**
     * @Route("/list/{id}", name="list", requirements={"id":"\d+"})
     */
    public function browseByCategory(CarCategoryRepository $carCategoryRepository, EntityManagerInterface $em, int $id, PaginatorInterface $paginator, Request $request)
    {
        $categories = $carCategoryRepository->findAll();

        $data = $em->createQuery(
            'SELECT c FROM App\Entity\Car c
            JOIN c.carCategory cc
            WHERE cc.id = ' . $id,
        );

        $cars = $paginator->paginate(
            $data->getResult(),
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('car/list.html.twig', [
            'categories' => $categories,
            'cars' => $cars,
        ]);
    }

    /**
     * @route("/read/{id}", name="read", requirements={"id":"\d+"})
     */
    public function read(CarRepository $carRepository, int $id)
    {
        $car = $carRepository->find($id);

        return $this->render('car/read.html.twig', [
            'car' => $car,
        ]);
    }

    /**
     * @Route("/search", name="search")
     */
    public function search(CarRepository $carRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $cars = [];

        $name = $request->query->get(('name'));
        $data = $carRepository->findBy(['name' => $name]);

        $cars = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            20
        );
        return $this->render('car/search.html.twig', [
            'controller_name' => 'CarController',
            'cars' => $cars
        ]);
    }
}
