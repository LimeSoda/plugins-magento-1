<?php


class LimeSoda_Cashpresso_Test_Helper_DataTest extends EcomDev_PHPUnit_Test_Case_Config
{
    protected function getHelper()
    {
        return Mage::helper('ls_cashpresso');
    }

    public function getTimeout()
    {
        $time = DateTime::createFromFormat('Y-m-d H:i:s', '2017-08-31 00:00:00');

        $timout = Mage::helper('ls_cashpresso')->getConvertTime($time->getTimestamp(), 2);
        $expected = '2017-08-31T02:00:00+00:00';

        $this->assertEquals($expected, $timout);
    }

    public function testDebt()
    {
        $params = array('minPaybackAmount' => 10, 'paybackRate' => 2);
        $price = 1000;

        $this->assertEquals(20, $this->getHelper()->getDebt($price, $params));

        $params = array('minPaybackAmount' => 2, 'paybackRate' => 10);

        $this->assertEquals(100, $this->getHelper()->getDebt($price, $params));

        $this->assertEquals(1, $this->getHelper()->getDebt(1, $params));

        $params = array('paybackRate' => 2);

        $this->assertEquals(0, $this->getHelper()->getDebt($price, $params));
    }

    public function testHashCheck()
    {
        $helperMock = $this->getHelperMockBuilder('ls_cashpresso');
        $helperMock->method('getSecretKey')->willReturn('test');
        
        $response = array(
            'status' => 'SUCCESS',
            'referenceId' => '100',
            'usage' => '200',
            'verificationHash' => 'fa9f5ec800d771fa491d61e643b9bb3bd44a3eedb8b76e14f01afefd4f5d8dd83d4e570703c73b98dfe4b378defd76367970155e908b88f20dc03d3acd28dfb2'
        );

        $helper = Mage::helper('ls_cashpresso/request');

        $this->assertTrue($helper->hashCheck($response, $helperMock->getSecretKey()));

        unset($response['verificationHash']);

        $this->assertFalse($helper->hashCheck($response, $helperMock->getSecretKey()));
    }
}