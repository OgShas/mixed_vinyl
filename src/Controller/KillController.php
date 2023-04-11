<?php

namespace App\Controller;

use App\Entity\KillerData;
use Doctrine\ORM\EntityManagerInterface;
use http\Env\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
class KillController extends AbstractController
{

    #[Route('/killer')]
      public function newKiller(EntityManagerInterface $entity) :\Symfony\Component\HttpFoundation\Response
    {
         $killer=new KillerData();
         $killer->setName("Django Unchained");
         $killer->setCountry("Berkowica");
         $killer->setWeapon("Hand");

         $entity->persist($killer);
         $entity->flush($killer);

        return $this->render('vinyl/killer.html.twig',['killer'=>$killer]);
    }
}