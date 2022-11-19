<?php

namespace App\Controller\Admin;

use App\Entity\Car;
use App\Form\CarType;
use App\Repository\CarRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CarCategoryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/car", name="admin-car-")
 */
class CarController extends AbstractController
{
    /**
     * @Route("", name="browse", methods={"GET"})
     */
    public function browse(CarRepository $carRepository): Response
    {
        return $this->render('admin/car/browse.html.twig', [
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

        return $this->render('admin/car/list.html.twig', [
            'categories' => $categories,
            'cars' => $cars,
        ]);
    }

    /**
     * @route("/read/{id}", name="read", requirements={"id":"\d+"})
     */
    public function read(Car $car)
    {
        return $this->render('admin/car/read.html.twig', [
            'car' => $car,
        ]);
    }

    /**
     * @route("/add", name="add")
     */
    public function add(Request $request, EntityManagerInterface $em, ManagerRegistry $doctrine)
    {
        $car = new Car();
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em =  $doctrine->getManager();
            $em->persist($car);
            $em->flush();

            return $this->redirectToRoute('admin-car-browse');
        }

        return $this->render('admin/car/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @route("/edit/{id}", name="edit", requirements={"id":"\d+"})
     */
    public function edit(Request $request, EntityManagerInterface $em, ManagerRegistry $doctrine, int $id)
    {
        $car = $em->getRepository(Car::class)->find($id);
        if ($car) {
            $form = $this->createForm(CarType::class, $car);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em =  $doctrine->getManager();
                $em->persist($car);
                $em->flush();

                return $this->redirectToRoute('admin-car-browse');
            }
            return $this->render('admin/car/edit.html.twig', [
                'form' => $form->createView(),
            ]);
        } else {
            return false;
        }
    }

    /**
     * @route("/delete/{id}", name="delete", requirements={"id":"\d+"})
     */
    public function delete(EntityManagerInterface $em, int $id)
    {
        $car = $em->getRepository(Car::class)->find($id);

        if ($car) {
            $em->remove($car);
            $em->flush();
        } else {
            return false;
        }

        return $this->redirectToRoute('admin-car-browse');
    }
}
