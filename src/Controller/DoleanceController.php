<?php

namespace App\Controller;

use App\Entity\Doleance;
use App\Form\DoleanceType;
use App\Repository\DoleanceRepository;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Constraints\Date;

class DoleanceController extends AbstractController
{
    /**
     * @Route("/doleance", name="doleance")
     */
    public function list_doleance(DoleanceRepository $doleanceRepository, ManagerRegistry $managerRegistry, Request $request, PaginatorInterface $paginator): Response
    {
        $message = null;
        $doleance = new Doleance();
        $form = $this->createForm(DoleanceType::class, $doleance);
        $em = $managerRegistry->getManager();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            
            $em->persist($doleance);
            $em->flush();
            unset($doleance);
            unset($form);
            $doleance = new Doleance();
            $form = $this->createForm(DoleanceType::class, $doleance);
            $message = "Votre doléance a été bien envoyée";
        }
        
        $data = $doleanceRepository->myFindAll();

        $doleances = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            5
        );


        return $this->render('doleance/index.html.twig', [
            'doleances' => $doleances, 'form' => $form->createView(), 'message' => $message
        ]);


    }

    /**
     * @Route("api/doleance", name="doleance_api" )
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function api_doleance(DoleanceRepository $doleanceRepository, ManagerRegistry $managerRegistry, Request $request, PaginatorInterface $paginator): Response
    {
        
        $response = new Response();

        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        $data = $doleanceRepository->findAll();
        
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);
        $doleances = $serializer->serialize($data, 'json');

        $response->setContent($doleances);
        
        return $response;

    }

    
    /**
     * @Route("api/doleance/post", name="doleance_api_post", methods={"POST"})
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function api_doleance_post(DoleanceRepository $doleanceRepository, ManagerRegistry $managerRegistry, Request $request, PaginatorInterface $paginator): Response
    {
        
         $doleance = new Doleance();
        
        
         $em = $managerRegistry->getManager();
       
            $data = $request->getContent();
            $data = json_decode($data, true);

            $doleance->setSubject($data['subject']);
            $doleance->setEmail($data['email']);
            $doleance->setDescription($data['message']);
            $doleance->setPhone($data['phone']);

            $em->persist($doleance);
            $em->flush();

            $response = new Response();
          
            $response->setContent("Votre doléance a été bien envoyée");
            return $response;
       
    }

}
