<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



/**
 * @Route("post", name="post.")
 */
class PostController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @param PostRepository $postrepository
     * @return Response
     */
    public function index(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findAll();
        return $this->render('post/index.html.twig', [
            'posts' => $posts,
        ]);
    }
    /**
     * @Route("/create", name="create")
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        //create a new post with title
        $post = new Post();
        // $post->setTitle('this is going to be title');

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            /** @var UploadedFile $file */
            $file = $request->files->get('post')['attachment'];
            if ($file) {
                $filename =  md5(uniqid()) . '.' . $file->guessClientExtension();
                $file->move(
                    $this->getParameter('uploads_dir'),
                    $filename
                );
                $post->setImage($filename);
                //entity manager
                $em = $this->getDoctrine()->getManager();
                $em->persist($post);
                $em->flush();
            }
            return $this->redirect($this->generateUrl('post.index'));
        }
        //return a response
        return $this->render('post/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/show/{id}", name="show")
     * @param Post $post
     * @return Response
     */
    public function show(Post $post)
    // public function show($id, PostRepository $postRepository)
    {
        // $post = $postRepository->findPostWithCategory($id);

        return $this->render('post/show.html.twig', [
            'post' => $post
        ]);
    }
    /**
     * @Route("/delete/{id}", name="delete")
     *
     * @param  Post $post
     * @return Response
     */
    public function delete(Post $post)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($post);
        $em->flush();
        $this->addFlash('success', 'Post has been deleted');
        return $this->redirect($this->generateUrl('post.index'));
    }
}
