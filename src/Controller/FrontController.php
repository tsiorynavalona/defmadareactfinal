<?php

namespace App\Controller;

use App\Entity\BlogPost;
use App\Form\ContactType;
use App\Repository\BlogPostRepository;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bridge\Twig\Mime\NotificationEmail;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FrontController extends AbstractController
{
    /**
     * @Route("/accueil", name="home")
     */
    public function index(): Response
    {
        return $this->render('front/index.html.twig', [
            
        ]);
    }
    /**
     * @Route("/stat", name="stat")
     */
    public function stat(): Response
    {
        return $this->render('front/index.html.twig', [
            
        ]);
    }
    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request, MailerInterface $mailer, string $adminEmail): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $email = $form['email']->getData();
            $subject = $form['subject']->getData();
            $message = $form['message']->getData();

            $mailer->send((new NotificationEmail())
                ->subject($subject)
                ->htmlTemplate('emails/contact_notification.html.twig')
                ->from($email)
                ->to($adminEmail)
                ->context(['message' => $message])
            
            );
            
        }
        return $this->render('front/contact.html.twig', [
            'form' => $form->createView()
            
        ]);
    }

     /**
     * @Route("api/blogpost-home", name="blogposts_api_home")
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function blogpost_api_home(Request $request, BlogPostRepository $blogPostRepository): Response
    {
        


        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        

        $serializer = new Serializer($normalizers, $encoders);
        $blogpost = $blogPostRepository->findHome();
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
     * @Route("api/contact", name="contact_api_post", methods={"POST"})
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function contact_api(Request $request, MailerInterface $mailer, string $adminEmail): Response
    {
      
        $data = $request->getContent();
        
        $data = json_decode($data, true);
        $email = $data['email'];
        $subject = $data['subject'];
        $message = $data['message'];

        $mailer->send((new NotificationEmail())
                ->subject($subject)
                ->htmlTemplate('emails/contact_notification.html.twig')
                ->from($email)
                ->to($adminEmail)
                ->context(['message' => $message])
            
            );

        $response = new Response();

        
        $response->setContent($data);
        return $response;
    }



}