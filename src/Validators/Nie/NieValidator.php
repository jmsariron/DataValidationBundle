<?php

namespace Irontec\DataValidator\Validators\Nie;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NieValidator extends ConstraintValidator
{
    private const NIE_VALIDATION_REGEX = '/[XYZ]{1}\d{7}[a-zA-Z]{1}/m';
    private const NIE_VALID_LAST_CHARS = 'TRWAGMYFPDXBNJZSQVHLCKE';
    private const NIE_FIRST_CHAR_VALUE = ['X' => 0, 'Y' => 1, 'Z' => 2];

    public function validate($value, Constraint $constraint)
    {
        if (is_null($value)  && $constraint->nullable === true)
            return;

        if (!$this->isValidNie($value))
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->addViolation();
    }

    protected function isValidNie(string $nie): bool {
        return $this->hasValidLength($nie) && $this->hasValidLastChar($nie);
    }

    protected function hasValidLength(string $nie): bool {
        $hasMatch = preg_match(self::NIE_VALIDATION_REGEX, $nie, $matches);

        if (!$hasMatch)
            return false;

        return strlen($nie) === strlen($matches[0]);
    }

    protected function hasValidLastChar(string $nie): bool {
        $lastChar = strtoupper(substr($nie, -1, 1));

        $hasMatch = preg_match('/\d{7}/m', $nie, $matches);

        if (!$hasMatch)
            return false;

        $firstChar = strtoupper(substr($nie, 0, 1));
        $firstCharEquivalent = self::NIE_FIRST_CHAR_VALUE[$firstChar];

        $numberValue = intval($firstCharEquivalent . $matches[0]);

        return $lastChar === substr(self::NIE_VALID_LAST_CHARS, $numberValue % 23, 1);
    }
}