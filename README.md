# PHPix

Bibllioteca para gerar qrcodes do PIX

## Instalação

```sh
$ composer require hevertonfreitas/PHPix
```

## Uso

```php
<?php

use Hevertonfreitas\PHPix\Payload;
use Hevertonfreitas\PHPix\QRCode;

// Instancia classe Payload com os dados do PIX a ser gerado
$payload = new Payload();
$payload
    ->setPixKey('PIXKEY1234567890',  Payload::PIX_KEY_RANDOM)
    ->setTxid('1234567890')
    ->setAmount(200)
    ->setMerchantName('Nome')
    ->setMerchantCity('Cidade')
    ->setPostalCode('12345678');

// Retorna string do código do PIX gerado
$PixCopiaCola = $payload->getPayload();

// Instancia classe QRCode
$qrCode = new QRCode($payload);

// Retorna imagem em formato binário
$qrCodeImage = $qrCode->getPngImage();
```

### Licença

The MIT License (MIT)
