<?php

namespace Irontec\DataValidator\Validators\Nie;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class Nie extends Constraint
{
    public bool $nullable;

    public $message = 'The string "{{ string }}" is not a valid NIE.';
}