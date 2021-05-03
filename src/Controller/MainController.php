<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/main", name="main")
     */
    public function index(): Response
    {
        return new Response(
            '<h1>Hello Symfony</h1>'
        );
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
        return new Response(
            '<h1>Welcome! ' . $name . '</h1>'
        );
    }
}
