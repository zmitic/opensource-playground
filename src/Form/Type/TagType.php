<?php

declare(strict_types=1);

namespace App\Form\Type;

use App\Entity\Tag;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TagType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('value', TextType::class, [
            'label' => false,
            'get_value' => fn (Tag $tag) => $tag->getValue(),
            'update_value' => fn (string $value, Tag $tag) => $tag->setValue($value),
            'write_error_message' => 'You have to give value of tag.',
        ]);
    }

    public function factory(string $value): Tag
    {
        return new Tag($value);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tag::class,
            'factory' => [$this, 'factory'],
            'factory_error_message' => null,
            'error_mapping' => [
                '.' => 'value',
            ],
        ]);
    }
}
