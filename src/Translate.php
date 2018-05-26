<?php namespace NumberInterpreter;

trait Translate
{
    private function translate(string $text)
    {
        return Setup::$container->get('translator')->trans($text);
    }
}