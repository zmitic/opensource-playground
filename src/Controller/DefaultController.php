<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Comment;
use App\Form\Type\CommentType;
use App\Form\Type\TagsCollectionType;
use App\Repository\CommentRepository;
use App\Repository\TagRepository;
use App\ViewMapper\CommentViewMapper;
use App\ViewMapper\TagViewMapper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index(CommentRepository $commentRepository, TagRepository $tagRepository): Response
    {
        $comments = $commentRepository->findAll();
        $tags = $tagRepository->findAll();

        return $this->render('base.html.twig', [
            'comments' => CommentViewMapper::multiple($comments),
            'tags' => TagViewMapper::multiple($tags),
        ]);
    }

    /**
     * @Route("/edit_tags", name="tags_edit", methods={"GET", "POST"})
     */
    public function editAllTags(Request $request, TagRepository $tagRepository): Response
    {
        $form = $this->createForm(TagsCollectionType::class, $tagRepository->findAll());

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('default');
        }

        return $this->render('generic_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/create_product", name="product_create", methods={"GET", "POST"})
     */
    public function createProduct(Request $request): Response
    {
        $form = $this->createForm(CommentType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('default');
        }

        return $this->render('products/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit_product/{id}", name="product_edit", methods={"GET", "POST"})
     */
    public function editProduct(Request $request, Comment $product): Response
    {
        $form = $this->createForm(CommentType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('default');
        }

        return $this->render('products/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
