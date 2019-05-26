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
        $builder->add('first', EntityType::class, [
            'label' => false,
            'class' => Category::class,
            'required' => false,
            'placeholder' => '<Please select category>',
            'constraints' => [
//                new NotNull(),
            ],
            'get_value' => function (Product $product) {
                return $product->getCategory();
            },
            'update_value' => function (Category $category, Product $product) {
                $product->setCategory($category);
            },
            'write_error_message' => 'You must select category2',
//            'write_error_message' => null,
        ]);

        $builder->add('name', TextType::class, [
            'label' => false,
            'required' => false,
            'constraints' => [
//                new NotNull(),
                new Length(['min' => 2])
            ],
            'get_value' => function (Product $product) {
                return $product->getName();
            },
            'update_value' => function (string $name, Product $product) {
                $product->setName($name);
            },
            'write_error_message' => 'You must give name to product',
//            'write_error_message' => null,
        ]);
    }

    public function factory(Category $first, string $name): Product
    {
        return new Product($first, $name);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'factory' => [$this, 'factory'],
            'factory_error_message' => null,
            'data_class' => Product::class,
            'error_mapping' => [
                'category' => 'first',
            ]
        ]);
    }
}
