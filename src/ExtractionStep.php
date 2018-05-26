<?php namespace NumberInterpreter;

class ExtractionStep
{
    use Translate;

    private $text = "";
    private $rest = "";
    private $number = 0;
    
    public function __construct(string $text)
    {
        $this->text = $text;
    }

    /**
     * Checks if we can find any number word in the string.
     */
    public static function canExtract($text)
    {
        $canExtract = false;
        
        $canExtract |= NumberKnowledge::hasMagnitude($text);
        $canExtract |= NumberKnowledge::hasTen($text);
        $canExtract |= NumberKnowledge::hasSingleNumber($text);
        
        return $canExtract;
    }
    
    public function execute()
    {
        // first try to get the highest magnitude number
        if (NumberKnowledge::hasMagnitude($this->text)) {
            $this->extractMagnitude();
        } elseif ($this->preferSingleOverTenInterpretation()) {
            if(NumberKnowledge::hasSingleNumber($this->text))
                $this->extractSingleNumber();
            elseif(NumberKnowledge::hasTen($this->text))
                $this->extractTen();
        } elseif(NumberKnowledge::hasTen($this->text)) {
            $this->extractTen();
        } elseif (NumberKnowledge::hasSingleNumber($this->text)) {
            $this->extractSingleNumber();
        }
    }
    
    public function extractMagnitude()
    {
        $magnitudeName = $this->getHighestMagnitudeAvailable($this->text);
        
        $position      = strpos($this->text, $this->translate($magnitudeName));
        $this->rest    = trim(substr($this->text, $position + strlen($this->translate($magnitudeName))));

        $interpreter   = new TextualNumberInterpreter();
        $amount        = $interpreter->interpret(trim(substr($this->text, 0, $position)));
        
        $this->number  = NumberKnowledge::MAGNITUDE[$magnitudeName] * max($amount, 1);

        return $this;
    }
    
    public function extractTen()
    {
        $tenValue = 0;
        $tenTranslatedName = "";
        $tenPosition = 0;
        
        foreach(NumberKnowledge::TENS as $tenName => $ten) {
            $tenTranslatedName = $this->translate($tenName);
            
            if (strpos($this->text, $tenTranslatedName) !== false) {
                $tenPosition = strpos($this->text, $tenTranslatedName);
                $tenValue = $ten;
                
            }
        }
        
        $this->rest = substr($this->text, 0, $tenPosition) . substr($this->text, $tenPosition + strlen($tenTranslatedName));
        
        $this->number = $tenValue;

        return $this;
    }

    public function extractSingleNumber()
    {
        $numberValue          = 0;
        $numberPosition       = 0;
        $numberTranslatedName = "";
        
        foreach(NumberKnowledge::SINGLE_NUMBERS as $numberName => $number) {
            $numberPosition = strpos($this->text, $this->translate($numberName));
            if ($numberPosition !== false) {
                $numberValue = $number;
                $numberTranslatedName = $this->translate($numberName);
            }
        }

        $this->number = $numberValue;
        $this->rest = substr($this->text, 0, $numberPosition) . substr($this->text, $numberPosition + strlen($numberTranslatedName));

        return $this;
    }

    private function preferSingleOverTenInterpretation()
    {
        $preferSingle = false;
        
        $singleNumber = (new ExtractionStep($this->text))->extractSingleNumber()->getNumber();
        $ten = (new ExtractionStep($this->text))->extractTen()->getNumber();

        return ($singleNumber > 10 && $singleNumber < 20);
    }
    
    private function getHighestMagnitudeAvailable(string $text)
    {
        $highestMagnitude = false;
        
        foreach(NumberKnowledge::MAGNITUDE as $magnitudeName => $magnitude) {
            if (strpos($text, $this->translate($magnitudeName)) !== false && $magnitude > $this->translate($highestMagnitude))
                $highestMagnitude = $magnitudeName;
        }

        return $highestMagnitude;
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function getRest()
    {
        return $this->rest;
    }
}