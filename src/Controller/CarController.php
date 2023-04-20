<?php

namespace App\Controller;

use App\Entity\Car;
use App\Form\CarPostFormType;
use App\Form\SearchCarsFormType;
use App\Repository\CarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/car')]
class CarController extends AbstractController
{
    #[Route('')]
    public function carHomepage(CarRepository $carRepository, Request $request): Response
    {
        $cars = $carRepository->findAll();

        $form = $this->createForm(SearchCarsFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $model = $form->get('model')->getData();
           // $make = $form->get('make')->getData();
           // $door = $form->get('door')->getData();
           // $year = $form->get('year')->getData();

            $cars = $carRepository->findBy([
                //'make' => $make,
                'model' => $model,
               // 'door' => $door,
               // 'year' => $year,
            ]);
        }

        return $this->render('car/carHome.html.twig', [
            'form' => $form,
            'car' => $cars,
        ]);
    }
//CRUD -

    #[Route('/create')]
    public function addCar(EntityManagerInterface $entityManager, Request $request): Response
    {
        $car = new Car();
        $form = $this->createForm(CarPostFormType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($car);
            $entityManager->flush();

            return $this->redirectToRoute('app_car_carhomepage');
        }
        return $this->render('car/create.html.twig', [
            'form' => $form,
        ]);
    }

      #[Route('/delete/{id}')]
     public function deleteCar(CarRepository $carRepository,EntityManagerInterface $entityManager, int $id) : Response
    {

        $carObject=$carRepository->find($id);
        $entityManager->remove($carObject);
        $entityManager->flush();

        return new Response("Deleted");
    }


}