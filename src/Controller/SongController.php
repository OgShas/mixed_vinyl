<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SongController extends AbstractController
{
    #[Route('/api/songs/{', methods:['GET'])]
    public function getSong(int $id,LoggerInterface $logger) : Response
    {
           $song=['id'=>$id,
          'name'=>'Creep',
          'url'=>'https://youtu.be/XFkzRNyygfk'];

           $logger->info('returning API response for song {song}',['song'=>$id,]);

           return $this->json($song);
    }

}