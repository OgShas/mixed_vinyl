<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\String\u;

class VinylController
{
    #[Route('/')]
    public function homePage() : Response {

        return new Response('The Response');
    }

    #[Route('/browse/{slug}')]
    public function   browse($slug=null) :Response {
         if($slug) {
             $title ='Genre: '. u(str_replace('-', ' ', $slug))->title(true);
         }else{
              $title="All Genres ";
         }

         return new Response($title);
    }
}