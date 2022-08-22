<?php


namespace Hevertonfreitas\PHPix;

use Bissolli\ValidadorCpfCnpj\CNPJ;
use Bissolli\ValidadorCpfCnpj\CPF;
use Hevertonfreitas\PHPix\Exception\InvalidCNPJException;
use Hevertonfreitas\PHPix\Exception\InvalidCPFException;
use Hevertonfreitas\PHPix\Exception\InvalidEmailException;
use Hevertonfreitas\PHPix\Exception\InvalidKeyException;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;
use Stringy\Stringy;

/**
 * Class Payload
 *
 * @package Hevertonfreitas\PHPix
 */
class Payload
{

    /**
     * IDs do Payload do Pix
     *
     * @var string
     */
    const ID_PAYLOAD_FORMAT_INDICATOR = '00';
    const ID_MERCHANT_ACCOUNT_INFORMATION = '26';
    const ID_MERCHANT_ACCOUNT_INFORMATION_GUI = '00';
    const ID_MERCHANT_ACCOUNT_INFORMATION_KEY = '01';
    const ID_MERCHANT_ACCOUNT_INFORMATION_DESCRIPTION = '02';
    const ID_MERCHANT_CATEGORY_CODE = '52';
    const ID_TRANSACTION_CURRENCY = '53';
    const ID_TRANSACTION_AMOUNT = '54';
    const ID_COUNTRY_CODE = '58';
    const ID_MERCHANT_NAME = '59';
    const ID_MERCHANT_CITY = '60';
    const ID_POSTAL_CODE = '61';
    const ID_ADDITIONAL_DATA_FIELD_TEMPLATE = '62';
    const ID_ADDITIONAL_DATA_FIELD_TEMPLATE_TXID = '05';
    const ID_CRC16 = '63';

    const PIX_KEY_CPF = 1;
    const PIX_KEY_CNPJ = 2;
    const PIX_KEY_EMAIL = 3;
    const PIX_KEY_PHONE = 4;
    const PIX_KEY_RANDOM = 5;

    /**
     * Chave do PIX
     *
     * @var string
     */
    private $pixKey;

    /**
     * Descrição do pagamento
     *
     * @var \Stringy\Stringy
     */
    private $description;

    /**
     * Nome do titular da conta
     *
     * @var \Stringy\Stringy
     */
    private $merchantName;

    /**
     * Cidade do titular da conta
     *
     * @var \Stringy\Stringy
     */
    private $merchantCity;

    /**
     * CEP da localidade onde é efetuada a transação
     *
     * @var \Stringy\Stringy
     */
    private $postalCode;

    /**
     * ID da transação PIX
     *
     * @var string
     */
    private $txid;

    /**
     * Valor da transação
     *
     * @var string
     */
    private $amount;

    /**
     * @return string
     */
    public function getPixKey()
    {
        return $this->pixKey;
    }

    /**
     * @param string $pixKey
     * @param int $tipo
     * @return Payload
     */
    public function setPixKey($pixKey, $tipo)
    {
        switch ($tipo) {
            case self::PIX_KEY_CPF:
                $cpf = new CPF($pixKey);
                if (!$cpf->isValid()) {
                    throw new InvalidCPFException();
                }
                $pixKey = preg_replace('/[^0-9]/', '', $pixKey);
                break;
            case self::PIX_KEY_CNPJ:
                $cnpj = new CNPJ($pixKey);
                if (!$cnpj->isValid()) {
                    throw new InvalidCNPJException();
                }
                $pixKey = preg_replace('/[^0-9]/', '', $pixKey);
                break;
            case self::PIX_KEY_EMAIL:
                if (filter_var($pixKey, FILTER_VALIDATE_EMAIL)) {
                    throw new InvalidEmailException();
                }
                break;
            case self::PIX_KEY_PHONE:
                $phoneUtil = PhoneNumberUtil::getInstance();
                $brazilianNumberProto = $phoneUtil->parse($pixKey, 'BR');
                $pixKey = $phoneUtil->format($brazilianNumberProto, PhoneNumberFormat::E164);
                break;
            case self::PIX_KEY_RANDOM:
                break;
            default:
                throw new InvalidKeyException();
        }

        $this->pixKey = $pixKey;

        return $this;
    }

    /**
     * @return \Stringy\Stringy
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Payload
     */
    public function setDescription($description)
    {
        $this->description = Stringy::create($description)
            ->toAscii()
            ->toUpperCase()
            ->first(72);

        return $this;
    }

    /**
     * @return \Stringy\Stringy
     */
    public function getMerchantName()
    {
        return $this->merchantName;
    }

    /**
     * @param string $merchantName
     * @return Payload
     */
    public function setMerchantName($merchantName)
    {
        $this->merchantName = Stringy::create($merchantName)
            ->toAscii()
            ->toUpperCase()
            ->first(25);

        return $this;
    }

    /**
     * @return \Stringy\Stringy
     */
    public function getMerchantCity()
    {
        return $this->merchantCity;
    }

    /**
     * @param string $merchantCity
     * @return Payload
     */
    public function setMerchantCity($merchantCity)
    {
        $this->merchantCity = Stringy::create($merchantCity)
            ->toAscii()
            ->toUpperCase()
            ->first(15);

        return $this;
    }


    /**
     * @return \Stringy\Stringy
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * @param string $postalCode
     * @return Payload
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = Stringy::create($postalCode)
            ->toAscii()
            ->toUpperCase()
            ->first(99);

        return $this;
    }

    /**
     * @return string
     */
    public function getTxid()
    {
        return $this->txid;
    }

    /**
     * @param string $txid
     * @return Payload
     */
    public function setTxid($txid)
    {
        $this->txid = $txid;

        return $this;
    }

    /**
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     * @return Payload
     */
    public function setAmount($amount)
    {
        $this->amount = number_format($amount, 2, '.', '');

        return $this;
    }

    /**
     * @param string $id
     * @param string $value
     * @return $string
     */
    private function getValue($id, $value)
    {
        $size = str_pad(strlen($value), 2, '0', STR_PAD_LEFT);

        return $id . $size . $value;
    }

    /**
     * @return string
     */
    private function getMerchantAccountInformation()
    {
        $gui = $this->getValue(self::ID_MERCHANT_ACCOUNT_INFORMATION_GUI, 'br.gov.bcb.pix');

        $key = $this->getValue(self::ID_MERCHANT_ACCOUNT_INFORMATION_KEY, $this->pixKey);

        $description = !empty($this->description) ? $this->getValue(self::ID_MERCHANT_ACCOUNT_INFORMATION_DESCRIPTION, $this->description) : '';

        return $this->getValue(self::ID_MERCHANT_ACCOUNT_INFORMATION, $gui . $key . $description);
    }

    /**
     * @return string
     */
    private function getAdditionalDataFieldTemplate()
    {
        $txid = $this->getValue(self::ID_ADDITIONAL_DATA_FIELD_TEMPLATE_TXID, $this->txid);

        return $this->getValue(self::ID_ADDITIONAL_DATA_FIELD_TEMPLATE, $txid);
    }

    /**
     * Método responsável por calcular o valor da hash de validação do código pix
     *
     * @return string
     */
    private function getCRC16($payload)
    {
        //ADICIONA DADOS GERAIS NO PAYLOAD
        $payload .= self::ID_CRC16 . '04';

        //DADOS DEFINIDOS PELO BACEN
        $polinomio = 0x1021;
        $resultado = 0xFFFF;

        //CHECKSUM
        if (($length = strlen($payload)) > 0) {
            for ($offset = 0; $offset < $length; $offset++) {
                $resultado ^= (ord($payload[$offset]) << 8);
                for ($bitwise = 0; $bitwise < 8; $bitwise++) {
                    if (($resultado <<= 1) & 0x10000) $resultado ^= $polinomio;
                    $resultado &= 0xFFFF;
                }
            }
        }

        //RETORNA CÓDIGO CRC16 DE 4 CARACTERES
        return self::ID_CRC16 . '04' . strtoupper(sprintf('%04x', $resultado));
    }

    /**
     * @return string
     */
    public function getPayload()
    {
        $payload = $this->getValue(self::ID_PAYLOAD_FORMAT_INDICATOR, '01');
        $payload .= $this->getMerchantAccountInformation();
        $payload .= $this->getValue(self::ID_MERCHANT_CATEGORY_CODE, '0000');
        $payload .= $this->getValue(self::ID_TRANSACTION_CURRENCY, '986');
        $payload .= $this->getValue(self::ID_TRANSACTION_AMOUNT, $this->amount);
        $payload .= $this->getValue(self::ID_COUNTRY_CODE, 'BR');
        $payload .= $this->getValue(self::ID_MERCHANT_NAME, $this->merchantName);
        $payload .= $this->getValue(self::ID_MERCHANT_CITY, $this->merchantCity);
        $payload .= !empty($this->postalCode) ? $this->getValue(self::ID_POSTAL_CODE, $this->postalCode) : '';
        $payload .= $this->getAdditionalDataFieldTemplate();

        return $payload . $this->getCRC16($payload);
    }
}
