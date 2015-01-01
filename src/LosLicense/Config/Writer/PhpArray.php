<?php
namespace LosLicense\Config\Writer;

use Zend\Config\Writer\PhpArray as ZfPhpArray;

class PhpArray extends ZfPhpArray
{
    public function processConfig(array $config)
    {
        $arraySyntax = array(
            'open' => $this->useBracketArraySyntax ? '[' : 'array(',
            'close' => $this->useBracketArraySyntax ? ']' : ')'
        );

        return $this->processIndented($config, $arraySyntax);
    }
}