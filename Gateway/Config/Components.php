<?php

declare(strict_types=1);

namespace Monri\Payments\Gateway\Config;

use Monri\Payments\Gateway\Config;

class Components extends Config
{
    const CODE = 'monri_components';
    const PAYMENT_ACTION = 'payment_action';

    /**
     * @param $resource
     * @param $object
     * @param null $storeId
     * @return string
     */
    public function getGatewayPaymentCreateURL($storeId = null)
    {
        return $this->getGatewayResourceURL('v2/payment/new', $storeId);
    }

    /**
     * @param null|int $storeId
     * @return string
     */
    public function getComponentsJsURL($storeId = null)
    {
        return $this->getGatewayResourceURL('dist/components.js', $storeId);
    }

    /**
     * @param null $storeId
     * @return string
     */
    public function getPaymentAction($storeId = null)
    {
        return $this->getValue(self::PAYMENT_ACTION, $storeId);
    }
}
