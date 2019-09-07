<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller{

    /**
     * @Route("/hello/{prenom}/{age}", name="hello")
     * Montre la page qui dit bonjour
     *
     * @return void
     */
    public function hello($prenom = "anonyme", $age = 0){
        return $this->render('hello.html.twig',[
            "prenom" => $prenom,
            "age" => $age
        ]);
    }

    /**
     * @Route("/", name="homepage")
     */
    public function home(){

        $prenoms = ["Nicolas" => 23 , "Andy" => 30, "Thomas" => 15];

        return $this->render("home.html.twig",[
            "title" => "Bonjour",
            "age" => 21,
            "prenoms" => $prenoms
        ]);
    }

}


?>