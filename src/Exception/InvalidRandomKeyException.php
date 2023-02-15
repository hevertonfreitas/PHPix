<?php
declare(strict_types=1);

namespace Hevertonfreitas\PHPix\Exception;

/**
 * Class InvalidRandomKeyException
 *
 * @package Hevertonfreitas\PHPix\Exception
 */
class InvalidRandomKeyException extends \Exception
{
    protected $message = 'Chave aleatória inválida!';
}
