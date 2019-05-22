<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Product;
use App\Form\Type\ProductType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('base.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    /**
     * @Route("/create_product", name="product_create", methods={"GET", "POST"})
     */
    public function createProduct(Request $request): Response
    {
        $form = $this->createForm(ProductType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            $this->getDoctrine()->getManager()->persist($product);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('default');
        }

        return $this->render('products/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit_product/{id}", name="product_edit", methods={"GET", "POST"})
     */
    public function editProduct(Request $request, Product $product): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            $this->getDoctrine()->getManager()->persist($product);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('default');
        }

        return $this->render('products/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
