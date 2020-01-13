<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController {


    /**
     * @Route("/", name="homepage")
     */
    public function home()
    {
        return new Response("Hello World");
    }
}



?>