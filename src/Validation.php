<?php
declare(strict_types=1);

namespace Hevertonfreitas\PHPix;

/**
 * Classe para validações
 *
 * Código obtido em https://github.com/cakephp/localized/blob/72132/src/Validation/BrValidation.php
 */
abstract class Validation
{

    /**
     * Valida um cpf
     *
     * @param string $check O valor a ser checado
     * @return bool
     */
    public static function validarCpf(string $check): bool
    {
        $check = trim(strval($check));

        // sometimes the user submits a masked CNPJ
        if (preg_match('/^\d\d\d.\d\d\d.\d\d\d\-\d\d/', $check)) {
            $check = str_replace(['-', '.', '/'], '', $check);
        } elseif (!ctype_digit($check)) {
            return false;
        }

        if (strlen($check) !== 11) {
            return false;
        }

        // repeated values are invalid, but algorithms fails to check it
        for ($i = 0; $i < 10; $i++) {
            if (str_repeat(strval($i), 11) === $check) {
                return false;
            }
        }

        $dv = substr($check, -2);
        for ($pos = 9; $pos <= 10; $pos++) {
            $sum = 0;
            $position = $pos + 1;
            for ($i = 0; $i <= $pos - 1; $i++, $position--) {
                $sum += (int)$check[$i] * $position;
            }
            $div = $sum % 11;
            $check[$pos] = $div < 2 ? 0 : 11 - $div;
        }
        $dvRight = (int)$check[9] * 10 + (int)$check[10];

        return $dvRight == $dv;
    }

    /**
     * Valida um cnpj
     *
     * @param string $check O valor a ser checado
     * @return bool
     */
    public static function validarCnpj(string $check): bool
    {
        $check = trim(strval($check));
        // sometimes the user submits a masked CNPJ
        if (preg_match('/^\d\d.\d\d\d.\d\d\d\/\d\d\d\d\-\d\d/', $check)) {
            $check = str_replace(['-', '.', '/'], '', $check);
        } elseif (!ctype_digit($check)) {
            return false;
        }

        if (strlen($check) !== 14) {
            return false;
        }
        $firstSum = ($check[0] * 5) + ($check[1] * 4) + ($check[2] * 3) + ($check[3] * 2) +
            ($check[4] * 9) + ($check[5] * 8) + ($check[6] * 7) + ($check[7] * 6) +
            ($check[8] * 5) + ($check[9] * 4) + ($check[10] * 3) + ($check[11] * 2);

        $firstVerificationDigit = $firstSum % 11 < 2 ? 0 : 11 - ($firstSum % 11);

        $secondSum = ($check[0] * 6) + ($check[1] * 5) + ($check[2] * 4) + ($check[3] * 3) +
            ($check[4] * 2) + ($check[5] * 9) + ($check[6] * 8) + ($check[7] * 7) +
            ($check[8] * 6) + ($check[9] * 5) + ($check[10] * 4) + ($check[11] * 3) +
            ($check[12] * 2);

        $secondVerificationDigit = $secondSum % 11 < 2 ? 0 : 11 - ($secondSum % 11);

        return ($check[12] == $firstVerificationDigit) && ($check[13] == $secondVerificationDigit);
    }

    /**
     * Valida um UUID - https://tools.ietf.org/html/rfc4122
     *
     * @param string $check O valor a ser checado
     * @return bool
     */
    public static function validarUUID(string $check): bool
    {
        $regex = '/^[a-fA-F0-9]{8}-[a-fA-F0-9]{4}-[0-5][a-fA-F0-9]{3}-[089aAbB][a-fA-F0-9]{3}-[a-fA-F0-9]{12}$/';

        return preg_match($regex, $check) !== 0;
    }
}
