<?php

namespace App\Controller;


use App\Entity\Killers;
use App\Form\KillersFormType;
use App\Repository\KillersRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/killer')]
class KillerController extends AbstractController
{
    #[Route('/list')]
    public function listKillers(KillersRepository $killersRepository): Response
    {
        return $this->render('killers/list.html.twig',[
            'killers' => $killersRepository->findAll(),
        ]);
    }


    #[Route('/view/{id}')]
    public function viewKiller(KillersRepository $killersRepository, int $id): Response
    {
        $object = $killersRepository->find($id);

        if (!$object) {
            return new Response('The given ID is missing.', Response::HTTP_NOT_FOUND);
        }

        return $this->render('killers/view.html.twig', [
            'killer' => $object,
        ]);
    }

    #[Route('/delete/{id}')]
    public function deleteKiller(KillersRepository $killersRepository, EntityManagerInterface $entityManager, int $id): Response
    {
        $object = $killersRepository->find($id);

        $entityManager->remove($object);

        $entityManager->flush();

        return new Response('Deleted successfully.');
    }

    #[Route('/create')]
    public function createKiller(EntityManagerInterface $entityManager, Request $request): Response
    {
        $killer = new Killers();

        $form = $this->createForm(KillersFormType::class, $killer);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the data to the database
            $entityManager->persist($killer);

            $entityManager->flush();

            return $this->redirectToRoute('app_killer_listkillers');

        }

        return $this->render('killers//create.html.twig', [
            'form' => $form,
        ]);
    }
}