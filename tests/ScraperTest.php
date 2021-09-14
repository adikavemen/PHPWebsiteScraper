#!/usr/bin/env php
<?php

require dirname(__DIR__)."\\vendor\autoload.php";
use PHPUnit\Framework\TestCase;
use Tools\Scraper;

class ScraperTest extends TestCase
{   
    public function setUp() : void
    {
        
        $this->scraper = new Scraper();
    }

    public function tearDown() : void
    {
        unset($this->scraper);
    }

    public function testPriceFetch()
    {
        $answer = [72,120,192,66,108,174];
        $output = $this->scraper->getPrices();
        $this->assertNotNull($output);
        $this->assertCount(6, $output, "Expected 6 packages");
        $this->assertContainsOnly("int",$output,"Expecting to recieve array with integers");
        
        #Check if all prices are positive
        for ($i=0; $i < 6; $i++) { 
            $this->assertGreaterThan(0,$output[$i]);
        }

        #Potentially unwanted test
        $this->assertEquals($answer, $output, "The annual prices are [72,120,192,66,108,174] As long as prices have not changed");
    }

    public function testDataGrab()
    {
        $answer = ["Option 40 Mins","Option 160 Mins","Option 300 Mins", "Option 480 Mins", "Option 2000 Mins", "Option 3600 Mins"];
        $output = $this->scraper->getData(".header.dark-bg");
        
        $this->assertNotNull($output);
        $this->assertCount(6, $output, "Expected 6 packages");

        for($i=0; $i < 6; $i++)
        {
            $this->assertStringStartsWith("Option ", $output[$i]);
        }
        
        
        $this->assertEquals($answer,$output, "The package names must be [\"Option 40 Mins\",\"Option 160 Mins\",\"Option 300 Mins\", \"Option 480 Mins\", \"Option 2000 Mins\", \"Option 3600 Mins\"]");
    }
}
?>