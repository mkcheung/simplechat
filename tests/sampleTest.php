<?php

namespace Entity\Message;
use Entity\Message;

class SampleTest extends PHPUnit_Framework_TestCase  {

    protected $mockedItem;

    public function testMessage()
    {
        $this->mockedItem = new Message('aTestMessage');

        static::assertInstanceOf(Message::class, $this->mockedItem);
        static::assertEquals('aTestMessage', $this->mockedItem->getMessage());
    }
}