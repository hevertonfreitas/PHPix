<?php

namespace Hevertonfreitas\PHPix;

use PHPUnit\Framework\TestCase;

class PayloadTest extends TestCase
{
    public function testPayload()
    {
        $payload = new Payload();

        $payload
            ->setPixKey('836.277.105-41', Payload::PIX_KEY_CPF)
            ->setDescription('Pagamento de Teste')
            ->setMerchantName('Heverton Coneglian')
            ->setMerchantCity('UMUARAMA')
            ->setAmount(5)
            ->setTxid('123');

        $expectedReturn = '00020126550014br.gov.bcb.pix0111836277105410218PAGAMENTO DE TESTE52040000530398654045.005802BR5918HEVERTON CONEGLIAN6008UMUARAMA62070503123630469E4';
        $this->assertEquals($expectedReturn, $payload->getPayload());
    }

    public function testPayloadDescription()
    {
        $payload = new Payload();

        $payload->setDescription('éUÀã');

        $this->assertEquals('EUAA', $payload->getDescription());
    }

    public function testPayloadMerchantName()
    {
        $payload = new Payload();

        $payload->setMerchantName('éUÀã');

        $this->assertEquals('EUAA', $payload->getMerchantName());
    }

    public function testPayloadMerchantCity()
    {
        $payload = new Payload();

        $payload->setMerchantCity('éUÀã');

        $this->assertEquals('EUAA', $payload->getMerchantCity());
    }

    public function testPayloadAmount()
    {
        $payload = new Payload();

        $payload->setAmount(10.5);
        $this->assertEquals('10.50', $payload->getAmount());

        $payload->setAmount(1);
        $this->assertEquals('1.00', $payload->getAmount());

        $payload->setAmount(12478.5);
        $this->assertEquals('12478.50', $payload->getAmount());
    }

    public function testPayloadKeyCPFCNPJ()
    {
        $payload = new Payload();

        $payload->setPixKey('836.277.105-41', Payload::PIX_KEY_CPF);
        $this->assertEquals('83627710541', $payload->getPixKey());

        $payload->setPixKey('153.270.342-24', Payload::PIX_KEY_CPF);
        $this->assertEquals('15327034224', $payload->getPixKey());

        $payload->setPixKey('24.358.351/0001-37', Payload::PIX_KEY_CNPJ);
        $this->assertEquals('24358351000137', $payload->getPixKey());

        $payload->setPixKey('21.483.760/0001-77', Payload::PIX_KEY_CNPJ);
        $this->assertEquals('21483760000177', $payload->getPixKey());
    }

    public function testPayloadKeyPhone()
    {
        $payload = new Payload();

        $payload->setPixKey('44985487892', Payload::PIX_KEY_PHONE);
        $this->assertEquals('+5544985487892', $payload->getPixKey());
    }
}
