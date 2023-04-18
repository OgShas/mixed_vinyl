<?php

namespace App\Controller;

use App\Entity\VinylMix;
use App\Repository\VinylMixRepository;
use Doctrine\ORM\EntityManagerInterface;
use http\Client\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MixController extends AbstractController
{

    #[Route('/mix/new')]
    public function new(EntityManagerInterface $entity): Response
    {
        $mix = new VinylMix();
        $mix->setTitle('Marilyn Manson the new Pope');
        $mix->setDescription('Say10');

        $genres = ['rock', 'pop'];
        $mix->setGenre($genres[array_rand($genres)]);

        $mix->setTrackCount(rand(10, 100));
        $mix->setVotes(rand(-100, 100));

        $entity->persist($mix);
        $entity->flush();

        return $this->render('vinyl/mix.html.twig',['mix'=>$mix]);
    }


   /* #[Route('/mix/{id}', name: 'app_mix_show')]
       public function show($id, VinylMixRepository $mixRepository)
     {
       $mix = $mixRepository->find($id);

        if(!$mix)
        {
            throw  $this->createNotFoundException('No Mix');
        }

        return $this->render('mix/show.html.twig', ['mix' => $mix,]);
       }*/


      #[Route('/mix/{id}',name:"app_mix_show")]
    public function show(VinylMix $mix) : Response
    {
      return $this->render('mix/show.html.twig',['mix'=>$mix]);
    }


    #[Route('/all',name: 'show_all')]
    public function showAll(VinylMixRepository $mixRepository)
    {
        $mix=$mixRepository->findAll();

        return $this->render('mix/showAll.html.twig',['mix'=>$mix]);
    }


    #[Route('//mix/{id}/vote',name:'app_mix_vote',methods: ['POST'])]
    public function vote(VinylMix $mix,\Symfony\Component\HttpFoundation\Request $request) : Response
    {
    $direction=$request->request->get('direction','up');
          if($direction==='up')
          {
              $mix->upVotes();
          }else{
              $mix->downVotes();
          }
    dd($mix);
    }
}
