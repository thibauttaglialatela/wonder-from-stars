<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class DateNotInFutureValidator extends ConstraintValidator
{
    /**
     * {@inheritDoc}
     */
    public function validate(mixed $value, Constraint $constraint): void
    {
        if ($value > new \DateTime()) {
            $this->context->buildViolation($constraint->getTargets())->addViolation();
        }
    }
}
