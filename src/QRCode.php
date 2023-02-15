<?php
declare(strict_types=1);

namespace Hevertonfreitas\PHPix;

use Mpdf\QrCode\Output\Html;
use Mpdf\QrCode\Output\Png;
use Mpdf\QrCode\Output\Svg;
use Mpdf\QrCode\QrCode as QRCodeImage;

class QRCode
{
    /**
     * @var \Hevertonfreitas\PHPix\Payload
     */
    private Payload $payload;

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
     * Retorna o objeto Mpdf\QrCode\QrCode do qrcode
     *
     * @return \Mpdf\QrCode\QrCode
     * @throws \Mpdf\QrCode\QrCodeException
     */
    public function getQRCodeImage(): QRCodeImage
    {
        return new QRCodeImage($this->payload->getPayload());
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
        return (new Png())->output($this->getQRCodeImage(), $size);
    }

    /**
     * Retorna a imagem de um payload em HTML
     *
     * @return string
     * @throws \Mpdf\QrCode\QrCodeException
     */
    public function getHtmlImage(): string
    {
        return (new Html())->output($this->getQRCodeImage());
    }

    /**
     * Retorna a imagem de um payload em SVG
     *
     * @param int $size Tamanho do qrcode
     * @return string
     * @throws \Mpdf\QrCode\QrCodeException
     */
    public function getSvgImage(int $size = 400): string
    {
        return (new Svg())->output($this->getQRCodeImage(), $size);
    }
}
