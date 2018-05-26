<?php namespace NumberInterpreter;

class NumberKnowledge
{
    use Translate;
    
    public const SINGLE_NUMBERS = [
        "one" => 1,
        "two" => 2,
        "three" => 3,
        "four" => 4,
        "five" => 5,
        "six" => 6,
        "seven" => 7,
        "eight" => 8,
        "nine" => 9,
        "eleven" => 11,
        "twelve" => 12,
        "thirteen" => 13,
        "fourteen" => 14,
        "fifteen" => 15,
        "sixteen" => 16,
        "seventeen" => 17,
        "eightteen" => 18,
        "nineteen" => 19,
    ];

    public const TENS = [
        "ten" => 10,
        "twenty" => 20,
        "thirty" => 30,
        "forty" => 40,
        "fifty" => 50,
        "sixty" => 60,
        "seventy" => 70,
        "eighty" => 80,
        "ninety" => 90
    ];

    public const MAGNITUDE = [
        "hundred" => 100,
        "thousand" => 1000,
        "million" => 1000000,
    ];

    public static function hasMagnitude(string $text)
    {
        $has = false;
        
        foreach(self::MAGNITUDE as $magnitudeName => $magnitude)
            $has |= strpos($text, self::translate($magnitudeName)) !== false;
        
        return $has;
    }
    
    public static function hasTen(string $text)
    {
        $has = false;
        
        foreach(self::TENS as $tenName => $tenValue)
            $has |= strpos($text, self::translate($tenName)) !== false;
        
        return $has;
    }

    public static function hasSingleNumber(string $text)
    {
        $has = false;
        
        foreach(self::SINGLE_NUMBERS as $singleName => $singleValue)
            $has |= strpos($text, self::translate($singleName)) !== false;
        
        return $has;
    }
}