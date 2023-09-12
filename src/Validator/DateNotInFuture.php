<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class DateNotInFuture extends Constraint
{
public string $message = "The date cannot be in the future";

}
