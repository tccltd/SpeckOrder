<?php

use PHPUnit_Framework_TestCase as TestCase;
use SpeckOrder\Entity\OrderLineMeta;

class OrderTest extends TestCase
{
    protected $orderLineMeta;


    public function setUp()
    {
        $this->orderLineMeta = new OrderLineMeta();
    }


    public function testProductId()
    {
        $meta = $this->orderLineMeta;
        $this->assertNull($meta['productId']);

        $meta->setProductId(1);
        $this->assertEquals(1, $meta['productId']);
    }

    public function testAdditionalMeta()
    {
        $addMeta = $this->getMock('SpeckOrder\Entity\OrderLineAdditionalMetaInterface', array('getIdentifier', 'setIdentifier'));
        $addMeta->expects($this->once())->method('getIdentifier')->will($this->returnValue('identifier'));
        $addMeta->expects($this->never())->method('setIdentifier');

        $meta = $this->orderLineMeta;
        $meta->addAdditionalMetadata($addMeta);
        $this->assertEquals(1, count($meta['additionalMetadata']));
        $this->assertSame($addMeta, $meta['additionalMetadata']['identifier']);
    }
}
