<?php
declare(strict_types=1);

namespace Hevertonfreitas\PHPix\Exception;

/**
 * Class InvalidEmailException
 *
 * @package Hevertonfreitas\PHPix\Exception
 */
class InvalidEmailException extends \Exception
{
    protected $message = 'Email inválido!';
}
