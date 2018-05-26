<?php namespace NumberInterpreter;

class TextualNumberInterpreter
{
    
    public function interpret(string $text)
    {
        $rest   = strtolower($text);
        $number = 0;
        
        while (ExtractionStep::canExtract($rest)) {
            $step = new ExtractionStep($rest);
            $step->execute();
            
            $rest    = $step->getRest();
            $number += (int) $step->getNumber();
        }

        return $number;
    }
    
    private function interpretNumberWord(string $text)
    {
        $number = 0;
        
        if (in_array(trim($text), self::MAGNITUDE))
            $number = self::MAGNITUDE[trim(text)];

        return $number;
    }
}
