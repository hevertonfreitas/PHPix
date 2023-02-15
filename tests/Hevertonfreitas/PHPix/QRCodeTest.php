<?php

namespace Hevertonfreitas\PHPix;

use PHPUnit\Framework\TestCase;

class QRCodeTest extends TestCase
{
    private function getPayload()
    {
        $payload = new Payload();

        $payload
            ->setPixKey('836.277.105-41', Payload::PIX_KEY_CPF)
            ->setDescription('Pagamento de Teste')
            ->setMerchantName('Heverton Coneglian')
            ->setMerchantCity('UMUARAMA')
            ->setAmount(5)
            ->setTxid('123');

        return new QRCode($payload);
    }

    public function testSvgImage()
    {
        $qrcode = $this->getPayload();

        $this->assertNotEmpty($qrcode->getSvgImage());
    }

    public function testHtmlImage()
    {
        $qrcode = $this->getPayload();

        $this->assertNotEmpty($qrcode->getHtmlImage());
    }

    public function testPngImage()
    {
        $qrcode = $this->getPayload();

        $this->assertEquals('image/png', getimagesizefromstring($qrcode->getPngImage())['mime']);
    }
}
