<?php

namespace App\Controller;

use App\Entity\Car;
use App\Repository\CarRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CarController extends AbstractController
{
    /**
     * @Route("/", name="browse", methods={"GET"})
     */
    public function browse(CarRepository $carRepository): Response
    {
        return $this->render('car/browse.html.twig', [
            'cars' => $carRepository->findAll(),
        ]);
    }

    /**
     * @Route("/read/{id}", name="read", requirements={"id":"\d+"}, methods={"GET|POST"})
     */
    public function read(CarRepository $carRepository, $id): Response
    {
        return $this->render('car/read.html.twig', [
            'cars' => $carRepository->findOneBy($id),
        ]);
    }
}
