<?php
declare(strict_types=1);

namespace Hevertonfreitas\PHPix;

use Mpdf\QrCode\Output\Png;

class QRCode
{
    /**
     * @var \Hevertonfreitas\PHPix\Payload
     */
    private $payload;

    /**
     * QRCode constructor.
     *
     * @param \Hevertonfreitas\PHPix\Payload $payload Payload do PIX
     */
    public function __construct(Payload $payload)
    {
        $this->payload = $payload;
    }

    /**
     * Retorna a imagem de um payload em PNG
     *
     * @param int $size Tamanho do qrcode
     * @return string
     * @throws \Mpdf\QrCode\QrCodeException
     */
    public function getPngImage(int $size = 400): string
    {
        $qrcode = new \Mpdf\QrCode\QrCode($this->payload->getPayload());

        return (new Png())->output($qrcode, $size);
    }
}
