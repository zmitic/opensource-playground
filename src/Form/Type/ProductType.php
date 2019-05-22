<?php

declare(strict_types=1);

namespace App\Form\Type;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('category', EntityType::class, [
            'class' => Category::class,
            'required' => false,
            'constraints' => [
                new NotNull(['message' => 'You must select category']),
            ],
            'read_property_path' => function (Product $product) {
                return $product->getCategory();
            },
            'write_property_path' => function (Product $product, Category $category) {
                $product->setCategory($category);
            },
        ]);
        $builder->add('name', TextType::class, [
            'required' => false,
            'constraints' => [
                new NotNull(['message' => 'You must set name']),
                new Length(['min' => 3]),
            ],
            'read_property_path' => function (Product $product) {
                return $product->getName();
            },
            'write_property_path' => function (Product $product, string $name) {
                $product->setName($name);
            },
        ]);
    }

    public function factory(Category $category, string $name): ?Product
    {
        return new Product($category, $name);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'empty_data' => null,
//            'data_class' => Product::class,
//            'exception_handling_strategy' => 'ignore',
            'factory' => [$this, 'factory'],
        ]);
    }
}
