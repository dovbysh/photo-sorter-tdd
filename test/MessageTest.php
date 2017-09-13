<?php

namespace dovbysh\PhotoSorterTest;


use dovbysh\PhotoSorterTdd\Message;
use PHPUnit\Framework\TestCase;

class MessageTest extends TestCase
{
    /**
     * @var Message
     */
    private $message;

    public function testLogCalled()
    {
        $m = $this->getMockBuilder(Message::class)->setMethods(['log'])->getMock();
        $m->expects($this->once())->method('log')->willReturnCallback(function ($message, $type) {
            return [$message, $type];
        });
        $this->assertEquals(['/zzz.txt', Message::TYPE_SKIPPED], $m->skipped('/zzz.txt'));
    }

    public function testSkipped()
    {
        $this->expectOutputString("[File skipped] /zzz.txt\n");
        $this->message->skipped('/zzz.txt');
    }

    public function testUnableToDetermineFileDate()
    {
        $this->expectOutputString("[UnableToDetermineFileDate] /zzz.txt\n");
        $this->message->unableToDetermineFileDate('/zzz.txt');
    }

    public function testFileExistsAndHasDifferentSize()
    {
        $this->expectOutputString("[FileExistsAndHasDifferentSize] /zzz.txt - 123; /xxx.txt - 456\n");
        $this->message->fileExistsAndHasDifferentSize('/zzz.txt', '/xxx.txt', 123, 456);
    }

    public function testSuccessCopied()
    {
        $this->expectOutputString("[OK] /zzz.txt -> /xxx.txt\n");
        $this->message->successCopied('/zzz.txt', '/xxx.txt');
    }

    protected function setUp()
    {
        parent::setUp();
        $this->message = new Message();
    }

    public function testFailedToCopy()
    {
        $this->expectOutputString("[FailedToCopy] /zzz.txt -> /t/zzz.txt\n");
        $this->message->failedToCopy('/zzz.txt', '/t/zzz.txt');
    }
//   public function test()
//    {
//        $this->expectOutputString("");
//        $this->message->('/zzz.txt');
//    }
}