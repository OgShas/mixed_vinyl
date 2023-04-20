<?php

namespace App\Controller;




use App\Repository\KillerDataRepository;
use App\Repository\VinylMixRepository;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\String\u;

class VinylController extends AbstractController
{

    private bool $isDebug;


    public function __construct(bool $isDebug)
    {
        $this->isDebug = $isDebug;
    }

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


    #[Route('/browse/{slug}', name: 'app_browse')]
    public function browse(VinylMixRepository $mixRepository,\Symfony\Component\HttpFoundation\Request $request, $slug = null): Response
    {
        $genre = $slug ? u(str_replace('-', ' ', $slug))->title(true) : null;

       $queryBuilder = $mixRepository->createVotesByQueryBuilder($slug);
       $adapter=new QueryAdapter($queryBuilder);
       $pagerfanta=Pagerfanta::createForCurrentPageWithMaxPerPage(
         $adapter,
          $request->query->get('page',1),
           9
       );

        return $this->render('vinyl/browse.html.twig',
            ['genre' => $genre,
                'pager' => $pagerfanta,
            ]);
    }


}
      
