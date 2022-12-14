<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/admin", name="admin-homepage")
     */
    public function home(): Response
    {
        return $this->render('admin/homepage.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
