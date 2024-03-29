<?php
declare(strict_types=1);

namespace Hevertonfreitas\PHPix;

use Hevertonfreitas\PHPix\Exception\InvalidCNPJException;
use Hevertonfreitas\PHPix\Exception\InvalidCPFException;
use Hevertonfreitas\PHPix\Exception\InvalidEmailException;
use Hevertonfreitas\PHPix\Exception\InvalidKeyException;
use Hevertonfreitas\PHPix\Exception\InvalidRandomKeyException;
use PHPUnit\Framework\TestCase;
use TypeError;

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
            ->setPostalCode('87502-250')
            ->setAmount(5)
            ->setTxid('123');

        $expectedReturn = '00020126550014br.gov.bcb.pix0111836277105410218PAGAMENTO DE TESTE52040000530398654045.005802BR5918HEVERTON CONEGLIAN6008UMUARAMA610987502-250620705031236304A70C';
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


    public function testPayloadKeyEmail()
    {
        $payload = new Payload();

        $payload->setPixKey('foo@bar.com', Payload::PIX_KEY_EMAIL);
        $this->assertEquals('foo@bar.com', $payload->getPixKey());
    }

    public function testPayloadKeyRandom()
    {
        $payload = new Payload();

        $payload->setPixKey('c1991086-c5ab-4d2a-832e-731b1fe3177f', Payload::PIX_KEY_RANDOM);
        $this->assertEquals('c1991086-c5ab-4d2a-832e-731b1fe3177f', $payload->getPixKey());
    }

    public function testInvalidCPF()
    {
        $this->expectException(InvalidCPFException::class);

        $payload = new Payload();

        $payload->setPixKey('142.277.105-42', Payload::PIX_KEY_CPF);
    }

    public function testInvalidCNPJ()
    {
        $this->expectException(InvalidCNPJException::class);

        $payload = new Payload();

        $payload->setPixKey('24.358.351/0001-38', Payload::PIX_KEY_CNPJ);
    }

    public function testInvalidEmail()
    {
        $this->expectException(InvalidEmailException::class);

        $payload = new Payload();

        $payload->setPixKey('231', Payload::PIX_KEY_EMAIL);
    }

    public function testInvalidRandomKey()
    {
        $this->expectException(InvalidRandomKeyException::class);

        $payload = new Payload();

        $payload->setPixKey('231', Payload::PIX_KEY_RANDOM);
    }

    public function testInvalidStringKey()
    {
        $this->expectException(TypeError::class);

        $payload = new Payload();

        $payload->setPixKey('231', 'foo');
    }

    public function testInvalidKey()
    {
        $this->expectException(InvalidKeyException::class);

        $payload = new Payload();

        $payload->setPixKey('231', 123);
    }

    public function testGetTxid()
    {
        $payload = new Payload();

        $payload->setTxid('123');
        $this->assertEquals('123', $payload->getTxid());
    }

    public function testGetPostalCode()
    {
        $payload = new Payload();

        $payload->setPostalCode('87502250');
        $this->assertEquals('87502250', (string)$payload->getPostalCode());
    }
}
