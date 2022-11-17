<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\BlogPost;
use App\Form\CommentType;
use App\Form\BlogPostType;
use App\Repository\CommentRepository;
use App\Repository\BlogPostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\CategoryPostRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/blog")
 */
class BlogPostController extends AbstractController
{
   
      
    /**
     * @Route("/", name="blog_post_index", methods={"GET"})
     */
    public function index(BlogPostRepository $blogPostRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $data = $blogPostRepository->findAll();
        $blogPost = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            6
        );
        return $this->render('blog_post/index.html.twig', [
            'blog_posts' => $blogPost,
        ]);
    }
    /**
     * @Route("/userPosts", name="blog_post_user", methods={"GET"})
     */
    public function userBlog(BlogPostRepository $blogPostRepository): Response
    {
        return $this->render('blog_post/userBlog.html.twig', [
            'blog_posts' => $blogPostRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="blog_post_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $blogPost = new BlogPost();
        $form = $this->createForm(BlogPostType::class, $blogPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($blogPost);
            $entityManager->flush();

            return $this->redirectToRoute('blog_post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('blog_post/new.html.twig', [
            'blog_post' => $blogPost,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/post/{id}", name="blog_post_show", methods={"GET","POST"})
     */
    public function show(BlogPost $blogPost, BlogPostRepository $blogPostRepository, CategoryPostRepository $categoryPostRepository, CommentRepository $commentRepository, Request $request, ManagerRegistry $managerRegistry): Response
    {

        $em = $managerRegistry->getManager();
        $comment = new Comment();
        $commentPosts = $commentRepository->findByPost($blogPost->getId());
        $commentForm = $this->createForm(CommentType::class, $comment);
        $commentForm->handleRequest($request);
        $messageComment = null;
        if($commentForm->isSubmitted()) {
            $comment->setBlogPost($blogPost);
            $em->persist($comment);
            $em->flush();
            unset($comment);
            unset($form);
            $comment = new comment();
            $form = $this->createForm(CommentType::class, $comment);
            $messageComment = 'Nous avons reçu votre commentaire, nous allons d\'abord le consulter, puis l\'approuver';
            
        }

        $latest_blog_posts = $blogPostRepository->findLatest();
        $categories = $categoryPostRepository->findAll();
        return $this->render('blog_post/show.html.twig', [
            'latest_blog_posts' => $latest_blog_posts,
            'blog_post' => $blogPost,
            'categories' => $categories,
            'commentForm' => $commentForm->createView(),
            'commentPosts' => $commentPosts,
            'messageComment' => $messageComment
        ]);
    }

    /**
     * @Route("/{id}/edit", name="blog_post_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, BlogPost $blogPost, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BlogPostType::class, $blogPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('blog_post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('blog_post/edit.html.twig', [
            'blog_post' => $blogPost,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="blog_post_delete", methods={"POST"})
     */
    public function delete(Request $request, BlogPost $blogPost, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$blogPost->getId(), $request->request->get('_token'))) {
            $entityManager->remove($blogPost);
            $entityManager->flush();
        }

        return $this->redirectToRoute('blog_post_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/categorie/{name}", name="blog_post_byCategory", methods={"GET"})
     */
    public function postByCategory($name, BlogPostRepository $blogPostRepository, Request $request, PaginatorInterface $paginator): Response
    {
        
        $data = $blogPostRepository->findByCategory($name);
        $blogPost = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            6
        );
        return $this->render('blog_post/postByCategory.html.twig', [
            'blog_posts' => $blogPost,
            'name' => $name
        ]);
    }

     

    
}
