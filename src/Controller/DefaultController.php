<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Comment;
use App\Form\Type\CommentType;
use App\Form\Type\TagsCollectionType;
use App\Repository\CommentRepository;
use App\ViewMapper\CommentView;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index(CommentRepository $commentRepository): Response
    {
        $comments = $commentRepository->findAll();

        return $this->render('base.html.twig', [
            'comments' => CommentView::fromIterable($comments),
        ]);
    }

    /**
     * @Route("/edit_tags", name="tags_edit", methods={"GET", "POST"})
     */
    public function editAllTags(Request $request): Response
    {
        $form = $this->createForm(TagsCollectionType::class);

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
