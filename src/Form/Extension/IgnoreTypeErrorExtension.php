<?php

declare(strict_types=1);

namespace App\Form\Extension;

use ReflectionFunction;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use TypeError;
use Closure;

class IgnoreTypeErrorExtension extends AbstractTypeExtension
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'exception_handling_strategy' => 'ignore',
            'builder' => null,
            'factory' => null,
            'factory_error_message' => 'Some fields are invalid, please correct them',
        ]);

        $resolver->setAllowedTypes('factory_error_message', ['null', 'string']);
        $resolver->setAllowedTypes('factory', ['null', Closure::class]);

        $resolver->setNormalizer('empty_data', function (Options $options, $value) {
            /** @var ?Closure $factory */
            $factory = $options['factory'];
            if (null === $factory) {
                return $value;
            }
            $errorMessage = $options['factory_error_message'];

            return function (FormInterface $form) use ($factory, $errorMessage) {
                $values = [];
                $rf = new ReflectionFunction($factory);
                foreach ($rf->getParameters() as $reflectionParameter) {
                    $values[] = $form->get($reflectionParameter->getName())->getData();
                }

                try {
                    return $factory(...$values);
                } catch (TypeError $e) {
                    if ($errorMessage) {
                        $form->addError(new FormError($errorMessage, null, [], null, $e));
                    }

                    return null;
                }
            };
        });

        $resolver->setNormalizer('write_property_path', function (Options $options, ?callable $defaultValue) {
            if (null === $defaultValue) {
                return null;
            }

            return function ($data, $value) use ($defaultValue, $options) {
//                dd(123);
                try {
                    $defaultValue($data, $value);
                } catch (TypeError $e) {
                    dd($options);
                }
            };
        });
    }

    public static function getExtendedTypes(): iterable
    {
        return [FormType::class];
    }
}
