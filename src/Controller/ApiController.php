<?php

namespace App\Controller;

use App\Entity\BlogPost;
use App\Entity\Comment;
use App\Repository\CommentRepository;
use App\Repository\BlogPostRepository;
use App\Repository\CategoryPostRepository;
use App\Repository\DoleanceRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiController extends AbstractController
{
     /**
     * @Route("api/blogpost", name="blogpost_api" )
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function blogposts_api(Request $request, BlogPostRepository $blogPostRepository): Response
    {
        
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        

        $serializer = new Serializer($normalizers, $encoders);
        $blogpost = $blogPostRepository->findAll();
        $data = $serializer->serialize($blogpost, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        $response = new Response();

        $response->setContent($data);
        
        return $response;

    }

    /**
     * @Route("api/blogpost/{id}", name="blogpost_single_api" )
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function blogpost_single_api(Request $request, BlogPostRepository $blogPostRepository): Response
    {
        $id = $request->attributes->get('id');
        
        
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        

        $serializer = new Serializer($normalizers, $encoders);
        $blogpost = $blogPostRepository->findById($id);
        
        $data = $serializer->serialize($blogpost, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        
        $response = new Response();
        

        $response->setContent($data);
        
        return $response;

    }

    /**
     * @Route("api/blog/categorie/{nom_categorie}", name="blogpost_categorie_api" )
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function blogpost_categorie_api(Request $request, BlogPostRepository $blogPostRepository): Response
    {
        $nom = $request->attributes->get('nom_categorie');
        
        
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        

        $serializer = new Serializer($normalizers, $encoders);
        $blogpost = $blogPostRepository->findByCategory($nom);
        
        $data = $serializer->serialize($blogpost, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        $response = new Response();
        

        $response->setContent($data);
        
        return $response;

    }

    /**
     * @Route("api/blog/findlatest", name="blogpost_findlatest_api" )
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function blogpost_findlatest_api(Request $request, BlogPostRepository $blogPostRepository): Response
    {
        
        
        
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        

        $serializer = new Serializer($normalizers, $encoders);
        $blogpost = $blogPostRepository->findLatest();
        
        $data = $serializer->serialize($blogpost, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        $response = new Response();
        

        $response->setContent($data);
        
        return $response;

    }
    /**
     * @Route("api/blog/comments/{post_id}", name="blogpost_comment_api" )
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function blogpost_comment_api(Request $request, CommentRepository $commentRepository): Response
    {
        
        $id = $request->attributes->get('post_id');
        
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        
        $serializer = new Serializer($normalizers, $encoders);
        $comments = $commentRepository->findByPost($id);
        
        $data = $serializer->serialize($comments, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        $response = new Response();
        

        $response->setContent($data);
        
        return $response;

    }

    /**
     * @Route("blog/api/post_comment", name="comment_api_post", methods={"POST"})
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function comment_api_post(ManagerRegistry $managerRegistry, Request $request, BlogPostRepository $blogPostRepository): Response
    {
        
         $comment = new Comment();
        // $doleance->setSubject($request->request->get('subject'));
       
        // $doleance->setEmail($request->request->get('email'));
        // $doleance->setDescription($request->request->get('description'));
        // $doleance->setPhone($request->request->get('phone'));
        // $response = new Response();
        // $response->headers->set('Content-Type', 'application/json');
        // $response->headers->set('Access-Control-Allow-Origin', '*');

        
         $em = $managerRegistry->getManager();
        // // $em->persist($doleance);
        // // $em->flush();
        // $message_success = "Votre doléance a été bien envoyée"; 
            $data = $request->getContent();
            $data = json_decode($data, true);

            $comment->setName($data['nom']);
            $comment->setEmail($data['email']);
            $comment->setMessage($data['message']);
            $blogpost = new BlogPost;
            $blogpost = $blogPostRepository->find($data['post_id']);
            $comment->setBlogPost($blogpost);

            $em->persist($comment);
            $em->flush();

           
      
             $response = new Response();
            // $encoders = [new XmlEncoder(), new JsonEncoder()];
            // $normalizers = [new ObjectNormalizer()];
    
           // $serializer = new Serializer($normalizers, $encoders);
            //$doleances = $serializer->serialize($data, 'json');
            
        
    
            
                  
            $response->setContent("Votre Commentaire a été bien reçu, nous allons l'examiner avant de le publier");
            return $response;
       
       

    }

    /**
     * @Route("api/blog/categories", name="blogpost_categorie_all_api" )
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function blogpost_categorie_all_api(Request $request, CategoryPostRepository $categoryPostRepository): Response
    {
        $data = $categoryPostRepository->findAll();
        $response = new Response();
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

       $serializer = new Serializer($normalizers, $encoders);
        $categories = $serializer->serialize($data, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        
    

        
              
        $response->setContent($categories);
        return $response;
   
    }

    /**
     * @Route("api/doleance/nb", name="doleance_nb_api" )
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function doleance_nb_api(Request $request, DoleanceRepository $doleanceRepository): Response
    {
        $month = $request->query->get('month');
        $year = $request->query->get('year');
        $data = $doleanceRepository->findByDate($year, $month);
        $response = new Response();
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

       $serializer = new Serializer($normalizers, $encoders);
        $categories = $serializer->serialize($data, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        
    

        
              
        $response->setContent($categories);
        return $response;


    }


}
