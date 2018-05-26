<?php

use PHPUnit\Framework\TestCase;

use NumberInterpreter\Setup;
use NumberInterpreter\TextualNumberInterpreter;

class NumberInterpreterTests extends TestCase
{
    public function setUp()
    {
        Setup::init();
    }
    
    public function testBigNumbers()
    {
        $interpreter = new TextualNumberInterpreter;
        $this->assertEquals($interpreter->interpret("Duizend"), 1000);
        $this->assertEquals($interpreter->interpret("Honderdvierentwintigduizend driehonderdvijftig"), 124350);
        $this->assertEquals($interpreter->interpret("Tweemiljoen honderdvierentwintigduizend driehonderdvijftig"), 2124350);
    }
    
    public function testEnglish()
    {
        Setup::$container->setParameter('translator.language', 'en_GB');
        Setup::initTranslator();

        $interpreter = new TextualNumberInterpreter;
        $this->assertEquals($interpreter->interpret("Thousand"), 1000);
        $this->assertEquals($interpreter->interpret("Hundred fifty five"), 155);
        $this->assertEquals($interpreter->interpret("Two million hundred and twenty"), 2000120);
    }   
}