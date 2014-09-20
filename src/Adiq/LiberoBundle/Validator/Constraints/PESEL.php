<?php
namespace Adiq\LiberoBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;


/**
 * @Annotation
 */
class PESEL extends Constraint
{
    public $message = 'PESEL nie jest prawidłowy.';
}