<?php

namespace Irontec\DataValidator\Validators\Dni;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class DniValidator extends ConstraintValidator
{
    private const DNI_VALIDATION_REGEX = '/\d{8}[-]{0,1}[a-zA-Z]{1}/m';
    private const DNI_VALID_LAST_CHARS = 'TRWAGMYFPDXBNJZSQVHLCKE';

    public function validate($value, Constraint $constraint)
    {
        if (is_null($value)  && $constraint->nullable === true)
            return;

        if (!$this->isValidDni($value))
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->addViolation();
    }

    protected function isValidDni(string $dni): bool {
        return $this->hasValidLength($dni) && $this->hasValidLastChar($dni);
    }

    protected function hasValidLength(string $dni): bool {
        $hasMatch = preg_match(self::DNI_VALIDATION_REGEX, $dni, $matches);

        if (!$hasMatch)
            return false;

        return strlen($dni) === strlen($matches[0]);
    }

    protected function hasValidLastChar(string $dni): bool {
        $lastChar = strtoupper(substr($dni, -1, 1));

        $hasMatch = preg_match('/\d{8}/m', $dni, $matches);

        if (!$hasMatch)
            return false;

        $numberValue = intval($matches[0]);

        return $lastChar === substr(self::DNI_VALID_LAST_CHARS, $numberValue % 23, 1);
    }
}