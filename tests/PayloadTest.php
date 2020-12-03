<?php

namespace Hevertonfreitas\PHPix;

use PHPUnit\Framework\TestCase;

class PayloadTest extends TestCase
{
    public function testPayload()
    {
        $payload = new Payload();

        $payload
            ->setPixKey('12345678900')
            ->setDescription('Pagamento de Teste')
            ->setMerchantName('Heverton Coneglian')
            ->setMerchantCity('UMUARAMA')
            ->setAmount(5)
            ->setTxid('123');

        $expectedReturn = '00020126550014br.gov.bcb.pix0111123456789000218Pagamento de Teste52040000530398654045.005802BR5918Heverton Coneglian6008UMUARAMA6207050312363048FB8';
        $this->assertEquals($expectedReturn, $payload->getPayload());
    }
}
