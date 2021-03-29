<?php
/**
 * This file is part of the Monri Payments module
 *
 * (c) Monri Payments d.o.o.
 *
 * @author Favicode <contact@favicode.net>
 */

namespace Monri\Payments\Block\Adminhtml\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class TransactionTypes implements OptionSourceInterface
{

    /**
     * Return array of transaction types for redirect gateway.
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'purchase', 'label' => __('Purchase')],
            ['value' => 'authorize', 'label' => __('Authorize Only')],
        ];
    }
}
