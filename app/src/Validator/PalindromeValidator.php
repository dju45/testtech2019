<?php

namespace App\Validator;

use App\Services\PalindromeChecker;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

/**
 * @Annotation
 *
 */
class PalindromeValidator extends Constraint
{
    public $message = 'La valeure "{{ string }}" ne doit pas être un palindrome.';

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof PalindromeValidator) {
            throw new UnexpectedTypeException($constraint, PalindromeValidator::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');

        }

        $checker = new PalindromeChecker($value);

        if ($checker->isPalindrome() === false) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }
    }
}