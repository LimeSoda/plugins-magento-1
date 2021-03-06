<?php


class LimeSoda_Cashpresso_Block_Payment_Form_Cashpresso extends Mage_Payment_Block_Form
{
    /**
     * Instructions text
     *
     * @var string
     */
    protected $_instructions;

    /**
     * Block construction. Set block template.
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('limesoda/cashpresso/payment/form/method.phtml');
    }

    public function getMethodLabelAfterHtml()
    {
        return '<div id="cashpresso-availability-banner"></div>';
    }

    /**
     * Get instructions text from config
     *
     * @return string
     */
    public function getInstructions()
    {
        if ($this->_instructions === null) {
            $this->_instructions = $this->getMethod()->getInstructions();
        }
        return $this->_instructions;
    }

    public function refreshOptionalData()
    {
        $customerData = Mage::getModel('ls_cashpresso/customer')->getCustomerData(true);

        $list = array();

        if ($customerData->getEmail()) {
            $list['email'] = $customerData->getEmail();
        }

        if ($customerData->getFirstname()) {
            $list['given'] = $customerData->getFirstname();
        }

        if ($customerData->getLastname()) {
            $list['family'] = $customerData->getLastname();
        }

        if ($customerData->getDob()) {
            $list['birthdate'] = $customerData->getDob();
        }

        if ($customerData->getCountryCode()) {
            $list['country'] = $customerData->getCountryCode();
        }

        if ($customerData->getCity()) {
            $list['city'] = $customerData->getCity();
        }

        if ($customerData->getPostcode()) {
            $list['zip'] = $customerData->getPostcode();
        }

        if ($customerData->getStreet()) {
            $list['addressline'] = $customerData->getStreet();
        }

        if ($customerData->getTelephone()) {
            $list['phone'] = $customerData->getTelephone();
        }

        if ($customerData->getTaxvat()) {
            $list['iban'] = $customerData->getTaxvat();
        }

        $list = Mage::helper('core')->jsonEncode($list);

        $html = <<<EOT
C2EcomCheckout.refreshOptionalData($list);
EOT;

        return $html;
    }
}