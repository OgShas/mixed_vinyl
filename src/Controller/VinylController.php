<?php

namespace App\Controller;


use Knp\Bundle\TimeBundle\DateTimeFormatter;
use Psr\Cache\CacheItemInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;
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

        //$response=$httpClient->request('GET','https://m.imdb.com/title/tt1853728/fullcredits/cast');
       // $killer=$response->toArray();
       // dump($killer);


        $killer=$this->getKiller();
      //  dd($killer);
    //foreach ($killer as $key=> $kill){
   // $killer[$key]['country']='';
   // $killer[$key]['year']='';







        return $this->render('vinyl/killer.html.twig',
        ['killer'=>$killer]);
    }


    #[Route('/browse/{slug}', name: 'app_browse')]
    public function browse(HttpClientInterface $httpClient,CacheInterface $cache, $slug = null): Response
    {
      //  dump($cache);
        $genre = $slug ? u(str_replace('-', ' ', $slug))->title(true) : null;

         // $responese=$httpClient->request('GET','https://raw.githubusercontent.com/SymfonyCasts/vinyl-mixes/main/mixes.json');
        //$mixes=$responese->toArray();

        $mixes=$cache->get('mixes_data',function (CacheItemInterface  $cacheItem)use ($httpClient) {

            $cacheItem->expiresAfter(5);
            $responese=$httpClient->request('GET','https://raw.githubusercontent.com/SymfonyCasts/vinyl-mixes/main/mixes.json');
            return  $responese->toArray();
        });

       // foreach ($mixes as $key =>$mix){
        //    $mixes[$key]['ago']=$timeFormatter->formatDiff($mix['createdAt']);
       // }


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
         
            
      
