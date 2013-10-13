<?php namespace Worldpay;

class RequestTest extends TestCase {

  public function testSettingRequestParameters()
  {
    $wp = $this->getWorldpay();
    $request = $wp->request($this->getNormalRequest());
    $r = $request->prepare();
    $this->assertEquals('123456789', $r['data']['instId']);
    $this->assertEquals('my_shop', $r['data']['cartId']);
    $this->assertEquals('GBP', $r['data']['currency']);
    $this->assertEquals('99.99', $r['data']['amount']);
    $this->assertEquals(100, $r['data']['testMode']);
    $this->assertEquals('Philip Brown', $r['data']['name']);
    $this->assertEquals('phil@ipbrown.com', $r['data']['email']);
    $this->assertEquals('101 Blah Blah Lane', $r['data']['address1']);
    $this->assertEquals('London', $r['data']['town']);
    $this->assertEquals('E20 123', $r['data']['postcode']);
    $this->assertEquals('GB', $r['data']['country']);
    $this->assertEquals('123456789', $r['data']['telephone']);
    $this->assertEquals('123', $r['data']['MC_customer_id']);
    $this->assertEquals('456', $r['data']['MC_order_id']);
  }

  public function testSignature()
  {
    $wp = $this->getWorldpay();
    $request = $wp->request($this->getNormalRequest());
    $request->setSecret('my_secret');
    $r = $request->prepare();
    $this->assertEquals(md5('my_secret:123456789:my_shop:GBP:99.99'), $r['signature']);
  }

  public function testSignatureWithCustomFields()
  {
    $wp = $this->getWorldpay();
    $request = $wp->request($this->getNormalRequest());
    $request->setSecret('my_secret');
    $request->setSignatureFields(array('email'));
    $r = $request->prepare();
    $this->assertEquals(md5('my_secret:123456789:my_shop:GBP:99.99:phil@ipbrown.com'), $r['signature']);
  }

}
