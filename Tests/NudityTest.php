<?php
namespace YPL\Nudity\Tests;

use YPL\Nudity\Nudity;
use Imagine\Gd\Imagine;

class NudityTest extends \PHPUnit_Framework_TestCase
{
    function testNudity()
    {
        $imagine = new Imagine();
        $nudity = new Nudity($imagine);
        
        $this->assertFalse($nudity->detect(__DIR__.'/img/400_225_no.png'));
        $this->assertFalse($nudity->detect(__DIR__.'/img/400_225_yes.png'));
        $this->assertFalse($nudity->detect(__DIR__.'/img/400_225_yes.jpeg'));

    }
}