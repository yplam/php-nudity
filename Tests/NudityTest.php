<?php
namespace YPL\Nudity\Tests;

use YPL\Nudity\Nudity;
use Imagine\Gd\Imagine;

class NudityTest extends \PHPUnit_Framework_TestCase
{
    function testNudity()
    {
        $imagine = new Imagine();
        $nudity = new Nudity($imagine, array('debug'=>true));
        
        $yesFiles = array_diff(scandir(__DIR__.'/img/yes'), array('..', '.'));
        if(!empty($yesFiles)){
            foreach($yesFiles as $file){
                $this->assertTrue($nudity->detect(__DIR__.'/img/yes/'.$file));
            }
        }
        $noFiles = array_diff(scandir(__DIR__.'/img/no'), array('..', '.'));
        if(!empty($noFiles)){
            foreach($noFiles as $file){
                $this->assertFalse($nudity->detect(__DIR__.'/img/no/'.$file));
            }
        }

    }
}