<?php

namespace App\Interfaces;

/**
 * Interface TranslationServiceInterface
 * @package App\Interfaces
 */
interface TranslationServiceInterface
{
    /**
     * @param string $fromCode
     * @param string $targetCode
     * @param string $text
     * @return string
     */
    public function translate(string $fromCode, string $targetCode, string $text) : string;
}
