<?php

namespace Irontec\DataValidator\Validators\Dni;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class Dni extends Constraint
{
    public bool $nullable;

    public $message = 'The string "{{ string }}" is not a valid DNI.';
}