<?php
/**
 * This file is part of the Monri Payments module
 *
 * (c) Monri Payments d.o.o.
 *
 * @author Favicode <contact@favicode.net>
 */

namespace Monri\Payments\Gateway\Http\Components;

use Magento\Payment\Gateway\Http\TransferBuilder;
use Magento\Payment\Gateway\Http\TransferFactoryInterface;
use Magento\Payment\Gateway\Http\TransferInterface;
use Monri\Payments\Model\Crypto\Components\Digest;
use Monri\Payments\Gateway\Config\Components as Config;

class PaymentCreateTransferFactory implements TransferFactoryInterface
{
    /**
     * @var TransferBuilder
     */
    private $transferBuilder;

    /**
     * @var Config
     */
    private $config;

    /**
     * @var Digest
     */
    private $digest;

    /**
     * PaymentInitializeTransferFactory constructor.
     *
     * @param TransferBuilder $transferBuilder
     * @param Config $config
     * @param Digest $digest
     */
    public function __construct(
        TransferBuilder $transferBuilder,
        Config $config,
        Digest $digest
    ) {
        $this->transferBuilder = $transferBuilder;
        $this->config = $config;
        $this->digest = $digest;
    }

    /**
     * Builds order update transfer object.
     *
     * @param array $request
     * @return TransferInterface
     */
    public function create(array $request)
    {
        $storeId = null;
        if (isset($request['__store'])) {
            $storeId = $request['__store'];
            unset($request['__store']);
        }

        $uri = $this->config->getGatewayPaymentCreateURL($storeId);
        //$uri = 'https://ipgtest.monri.com/v2/payment/new';

        //@todo: Move this to Client?
        $clientAuthenticityToken = $this->config->getClientAuthenticityToken($storeId);
        $timestamp = time();
        //$orderId = $request['order_number'];
        $digest = $this->digest->build($timestamp, json_encode($request), $storeId);

        return $this->transferBuilder
                ->setUri($uri)
                ->setMethod('POST')
                ->setHeaders(['Authorization' => "WP3-v2 $clientAuthenticityToken $timestamp $digest"])
                ->setBody($request)
                ->build();
    }
}
