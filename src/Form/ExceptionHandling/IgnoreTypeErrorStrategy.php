<?php

declare(strict_types=1);

namespace App\Form\ExceptionHandling;

use SensioLabs\RichModelForms\ExceptionHandling\ExceptionHandlerInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Throwable;

/**
 * Used to avoid generic type errors when factory are used in form types.
 *
 * @see InvoiceType::factory()
 *
 * If user doesn't upload file, parameter $uploadedFile would be null; generic message looks like "This must be type App\Entity\File".
 *
 * By returning empty FormError, nothing happens and bundle reverts to usual validation.
 */
class IgnoreTypeErrorStrategy implements ExceptionHandlerInterface
{
    public function getError(FormInterface $form, $data, Throwable $e): ?FormError
    {
        dump($form, $data, $e);
//        return new FormError(null, null, [], null, $e);
        if ($form->isRoot()) {
            return new FormError('Some fields are invalid, please correct them.', null, [], null, $e);
        }

//        return null;
//        return new FormError(null, null, [], null, $e);
        return new FormError('You cannot left this value empty.', null, [], null, $e);
    }
}
