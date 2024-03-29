<?php
declare(strict_types=1);

namespace Hevertonfreitas\PHPix\Exception;

/**
 * Class InvalidCPFException
 *
 * @package Hevertonfreitas\PHPix\Exception
 */
class InvalidCPFException extends \Exception
{
    protected $message = 'CPF inválido!';
}
