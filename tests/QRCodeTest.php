<?php

namespace Hevertonfreitas\PHPix;

use PHPUnit\Framework\TestCase;

class QRCodeTest extends TestCase
{

    public function testPngImage()
    {
        $payload = new Payload();

        $payload
            ->setPixKey('836.277.105-41', Payload::PIX_KEY_CPF)
            ->setDescription('Pagamento de Teste')
            ->setMerchantName('Heverton Coneglian')
            ->setMerchantCity('UMUARAMA')
            ->setAmount(5)
            ->setTxid('123');
        $qrcode = new QRCode($payload);

        $this->assertNotEmpty($qrcode->getPngImage());
    }
}
