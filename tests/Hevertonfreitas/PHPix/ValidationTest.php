<?php
declare(strict_types=1);

namespace Hevertonfreitas\PHPix;

use PHPUnit\Framework\TestCase;

class ValidationTest extends TestCase
{
    public function testValidarUUID(): void
    {
        $this->assertTrue(Validation::validarUUID('00000000-0000-0000-0000-000000000000'));
        $this->assertTrue(Validation::validarUUID('550e8400-e29b-11d4-a716-446655440000'));
        $this->assertFalse(Validation::validarUUID('BRAP-e29b-11d4-a716-446655440000'));
        $this->assertTrue(Validation::validarUUID('550E8400-e29b-11D4-A716-446655440000'));
        $this->assertFalse(Validation::validarUUID('550e8400-e29b11d4-a716-446655440000'));
        $this->assertFalse(Validation::validarUUID('550e8400-e29b-11d4-a716-4466440000'));
        $this->assertFalse(Validation::validarUUID('550e8400-e29b-11d4-a71-446655440000'));
        $this->assertFalse(Validation::validarUUID('550e8400-e29b-11d-a716-446655440000'));
        $this->assertFalse(Validation::validarUUID('550e8400-e29-11d4-a716-446655440000'));
    }

    public function testValidarCPF()
    {
        $this->assertFalse(Validation::validarCpf('22692173811'));
        $this->assertFalse(Validation::validarCpf('50549727322'));
        $this->assertFalse(Validation::validarCpf('869.283.422-11'));
        $this->assertFalse(Validation::validarCpf('843.701.734-22'));
        $this->assertFalse(Validation::validarCpf('999.999.999-99'));

        $this->assertTrue(Validation::validarCpf('22692173813'));
        $this->assertTrue(Validation::validarCpf('50549727302'));
        $this->assertTrue(Validation::validarCpf('869.283.422-00'));
        $this->assertTrue(Validation::validarCpf('843.701.734-34'));

        $this->assertFalse(Validation::validarCpf('abcdefghi'));
    }

    public function testValidarCnpj()
    {
        $this->assertFalse(Validation::validarCnpj('04295165000133'));
        $this->assertFalse(Validation::validarCnpj('33530485000129'));
        $this->assertFalse(Validation::validarCnpj('04295166000101'));
        $this->assertFalse(Validation::validarCnpj('33530486000130'));
        $this->assertFalse(Validation::validarCnpj('04.295.165/0001-33'));
        $this->assertFalse(Validation::validarCnpj('33.530.485/0001-29'));
        $this->assertFalse(Validation::validarCnpj('04.295.166/0001-01'));
        $this->assertFalse(Validation::validarCnpj('33.530.486/0001-30'));
        $this->assertFalse(Validation::validarCnpj('33.530.48.6/0001-30'));
        $this->assertFalse(Validation::validarCnpj('	33.530.48.6/0001-30 '));
        $this->assertFalse(Validation::validarCnpj('33.530.48.6/000-130'));

        $this->assertTrue(Validation::validarCnpj('04295166000133'));
        $this->assertTrue(Validation::validarCnpj('33530486000129'));

        $this->assertFalse(Validation::validarCnpj('123456789123456'));
        $this->assertFalse(Validation::validarCnpj('062476224000121'));
        $this->assertFalse(Validation::validarCnpj('062476224000121'));
        $this->assertFalse(Validation::validarCnpj('062.476.224/0001-21'));
        $this->assertTrue(Validation::validarCnpj('62.476.224/0001-21'));
        $this->assertTrue(Validation::validarCnpj('62476224000121'));
        $this->assertTrue(Validation::validarCnpj('62476224000121'));
    }
}
