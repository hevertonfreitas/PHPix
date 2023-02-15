<?php
declare(strict_types=1);

namespace Hevertonfreitas\PHPix\Exception;

/**
 * Class InvalidCNPJException
 *
 * @package Hevertonfreitas\PHPix\Exception
 */
class InvalidCNPJException extends \Exception
{
    protected $message = 'CNPJ inválido!';
}
