<?php
namespace Adiq\LiberoBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PESELValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!preg_match('/^[0-9]{2}[0-9]{2}[0-9]{2}[0-9]{5}$/', $value, $matches)) {
            $this->context->addViolation(
                $constraint->message,
                array('%string%' => $value)
            );
        } elseif ((1 > intval(substr($value, 2, 2))) OR (intval(substr($value, 2, 2)) > 12)) {
            $this->context->addViolation(
                $constraint->message,
                array('%string%' => $value)
            );
        } elseif ((1 > intval(substr($value, 4, 2))) OR (intval(substr($value, 4, 2)) > 31)) {
            $this->context->addViolation(
                $constraint->message,
                array('%string%' => $value)
            );
        }
       
    }
}