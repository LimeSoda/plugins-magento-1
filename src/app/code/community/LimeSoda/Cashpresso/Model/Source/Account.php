<?php


class LimeSoda_Cashpresso_Model_Source_Account
{

    protected function _helper()
    {
        return Mage::helper('ls_cashpresso');
    }

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => 1, 'label'=>Mage::helper('adminhtml')->__('Live')),
            array('value' => 0, 'label'=>Mage::helper('adminhtml')->__('Test')),
        );
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return array(
            0 => Mage::helper('adminhtml')->__('Test'),
            1 => Mage::helper('adminhtml')->__('Live'),
        );
    }
}