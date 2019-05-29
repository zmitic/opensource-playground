<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Comment;
use App\Form\Type\CommentType;
use App\Repository\CommentRepository;
use function array_map;
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
            'comments' => array_map(function (Comment $comment) {
                return [
                    'id' => $comment->getId(),
                    'body' => $comment->getBody(),
                ];
            }, $comments),
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
