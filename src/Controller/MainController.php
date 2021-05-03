<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render("home/index.html.twig");
        /* return new Response(
            '<h1>Hello Symfony</h1>'
        ); */
    }

    /**
     * @Route("/custom/{name?}", name="custom")
     *
     * @param  mixed $var
     * @return void
     */
    public function custom(Request $request)
    {
        $name = $request->get('name');
        return $this->render('home/custom.html.twig', [
            'name' => $name
        ]);
    }
}
