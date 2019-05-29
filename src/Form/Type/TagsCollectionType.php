<?php

declare(strict_types=1);

namespace App\Form\Type;

use App\Repository\TagRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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

        $builder->setData($data);
        foreach ($tags as $key => $tag) {
            $builder->add('tag_'.$key, TagType::class, [
                'data' => $tag
            ]);
        }

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
        ]);
    }
}
