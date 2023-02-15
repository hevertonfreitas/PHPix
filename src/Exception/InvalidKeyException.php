<?php
declare(strict_types=1);

namespace Hevertonfreitas\PHPix\Exception;

/**
 * Class InvalidKeyException
 *
 * @package Hevertonfreitas\PHPix\Exception
 */
class InvalidKeyException extends \Exception
{
    protected $message = 'Chave PIX inválida!';
}
