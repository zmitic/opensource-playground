<?php

declare(strict_types=1);

namespace App\Form\Type;

use App\Entity\Post;
use App\Entity\Comment;
use App\Entity\Tag;
use Braincrafted\Bundle\BootstrapBundle\Form\Type\BootstrapCollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('post', EntityType::class, [
            'class' => Post::class,
            'required' => false,
            'constraints' => [
            ],
            'placeholder' => '<Please select category>',
            'get_value' => function (Comment $product) {
                return $product->getPost();
            },
            'update_value' => function (Post $category, Comment $product) {
                $product->setPost($category);
            },
            'write_error_message' => 'You must select category',
        ]);

        $builder->add('body', TextType::class, [
            'required' => false,
            'constraints' => [
            ],
            'get_value' => function (Comment $product) {
                return $product->getBody();
            },
            'update_value' => function (string $name, Comment $product) {
                $product->setBody($name);
            },
            'write_error_message' => 'You must give name to product',
        ]);

        if ($options['use_collection']) {
            $builder->add('xxx', BootstrapCollectionType::class, [
                'property_path' => 'tags',
                'entry_type' => TagType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => false,
                'get_value' => function (Comment $comment) {
                    return $comment->getTags();
                },
                'add_value' => function (Tag $tag, Comment $comment) {
                    $comment->addTag($tag);
                },
                'remove_value' => function (Tag $tag, Comment $comment) {
                    $comment->removeTag($tag);
                },
                'write_error_message' => null,
            ]);
        } else {
            $builder->add('xxx', EntityType::class, [
                'class' => Tag::class,
                'multiple' => true,
                'get_value' => function (Comment $comment) {
                    return $comment->getTags();
                },
                'add_value' => function (Tag $tag, Comment $comment) {
                    $comment->addTag($tag);
                },
                'remove_value' => function (Tag $tag, Comment $comment) {
                    $comment->removeTag($tag);
                },
            ]);
        }
    }

    public function factory(Post $post, string $body): Comment
    {
        return new Comment($post, $body);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'factory' => [$this, 'factory'],
            'factory_error_message' => null,
            'data_class' => Comment::class,
            'use_collection' => true,
            'error_mapping' => [
//                'body' => 'name',
            ],
        ]);
    }
}
