<?php

namespace App\Controller;

use App\Entity\VinylMix;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MixController extends AbstractController
{

    #[Route('/mix/new')]
    public function new(EntityManagerInterface $entity) : Response
    {
        $mix=new VinylMix();
        $mix->setTitle('Marilyn Mansoon the new Pope');
        $mix->setDescription('Say10');
        $mix->setGenre('Rock');
        $mix->setTrackCount(rand(10,100));
        $mix->setVotes(rand(-100,100));

        $entity->persist($mix);
        $entity->flush();

        return new Response(sprintf('Mix %d is %d tracks of Hell',$mix->getId(),$mix->getTrackCount()));
    }

}