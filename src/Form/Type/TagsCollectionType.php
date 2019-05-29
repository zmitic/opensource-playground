<?php

declare(strict_types=1);

namespace App\Form\Type;

use App\Entity\Tag;
use App\Repository\TagRepository;
use Braincrafted\Bundle\BootstrapBundle\Form\Type\BootstrapCollectionType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Valid;

class TagsCollectionType extends AbstractType
{
    private $tagRepository;

    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $tags = $this->tagRepository->findAll();
        $data = [
            'tags' => $tags,
        ];

        $builder->add('tags', BootstrapCollectionType::class, [
            'entry_type' => TagType::class,
            'allow_add' => true,
            'allow_delete' => true,
            'label' => false,
            'constraints' => [
                new Valid(),
            ],
            'get_value' => function (array $data) {
                return $data['tags'];
            },
            'add_value' => function (Tag $tag) {
                $this->tagRepository->persist($tag);
            },
            'remove_value' => function (Tag $tag) {
                $this->tagRepository->remove($tag);
            },
            'write_error_message' => null,
        ]);
        $builder->setData($data);
    }
}
