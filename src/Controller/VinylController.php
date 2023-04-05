<?php

namespace App\Controller;


use App\Service\MixRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use function Symfony\Component\String\u;

class VinylController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function homePage(): Response
    {
        $tracks = [
            ['song' => 'Gangsta\'s Paradise', 'artist' => 'Coolio'],
            ['song' => ' Waterfalls', 'artist' => 'TLC'],
            ['song' => 'Creep', 'artist' => 'Radiohead'],
            ['song' => 'Show me how to live', 'artist' => 'Audioslave'],
            ['song' => 'Nobodies', 'artist' => 'Marilyn Manson'],
            ['song' => 'Simple man', 'artist' => 'Lynyrd Skynyrd'],
        ];

        return $this->render("vinyl/homepage.html.twig",
            ['title' => 'PB & Jams',
                'tracks' => $tracks,
            ]);
    }

    #[Route('/killer')]
    public function killer(HttpClientInterface $httpClient) :Response {
         // TODO conncect to db
        //$response=$httpClient->request('GET','DataBase');
       // $killer=$response->toArray();
       // dump($killer);

        $killer=$this->getKiller();

        return $this->render('vinyl/killer.html.twig',
        ['killer'=>$killer]);
    }


    #[Route('/browse/{slug}', name: 'app_browse')]
    public function browse(MixRepository $mixRepository, $slug = null): Response
    {
        $genre = $slug ? u(str_replace('-', ' ', $slug))->title(true) : null;

        $mixes=$mixRepository->findAll();

        return $this->render('vinyl/browse.html.twig',
            ['genre' => $genre,
                'mixes' => $mixes,
            ]);
    }



    private function getKiller(): array
{
        return [
            [
                'name'=>'Django Unchained',
                'kills'=>12,
                'weapon'=>'hand',
                'country'=>'Texas',
                'year'=>'1792-04-27',


            ],
            [
                'name'=>'Dr. King Schiltz',
                'kills'=>22,
                'weapon'=>'knife',
                'country'=>'Varna',
                'year'=>'1765-10-14',
            ]

        ];
}

}
         
            
      
