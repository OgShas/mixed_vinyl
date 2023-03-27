<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\String\u;

class VinylController extends AbstractController
{
    #[Route('/')]
    public function homePage() : Response {

        $tracks=[
            ['song'=>'Gangsta\'s Paradise','artist'=>'Coolio'],
            ['song'=>' Waterfalls','artist'=>'TLC'],
            ['song'=>'Creep','artist'=>'Radiohead'],
            ['song'=>'Show me how to live','artist'=>'Audioslave'],
            ['song'=>'Nobodies','artist'=>'Marilyn Manson'],
            ['song'=>'Simple man','artist'=>'Lynyrd Skynyrd'],

        ];

        $tracks2=[
            ['song'=>'Bunker','artist'=>'Balthazar'],
            ['song'=>'Hero','artist'=>'Foo Fighters'],
            ['song'=>'Age of Machine','artist'=>'Greta Van Fleet'],
            ['song'=>'High and Dry','artist'=>'Radiohead'],
            ['song'=>'I Know','artist'=>'Placebo'],

        ];

        return $this->render("vinyl/homepage.html.twig",
            ['title'=>'PB & Jams',
                'tracks'=>$tracks,
                'tracks2'=>$tracks2,
                ]);
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