<?php

use PHPUnit\Framework\TestCase;

class AutherTest extends TestCase {

    /**
     * @return \Simplicate\Rainforest\Auther
     */
    private function getAuther() {
        return new \Simplicate\Rainforest\Auther('key');
    }

    public function testVerify() {
        $auther = $this->getAuther();
        self::assertTrue($auther->verify('65f2253344287b3c5634a1ce6163fb694b2280b1', 'test', ['option' => 1]));
        self::assertFalse($auther->verify('65f2253344287b3c5634a1ce6163fb694b2280b1', 'test', ['option' => 2]));
    }

    public function testGetCallbackUrl() {
        $auther = $this->getAuther();

        $runId = 123123;
        $callbackType = 'before_run';

        self::assertEquals(
            "https://app.rainforestqa.com/api/1/callback/run/{$runId}/{$callbackType}/44cce68efc69c2664c7d1d13353eb0ad708dc5e6",
            $auther->getCallbackUrl($runId, $callbackType)
        );
    }
    
}
