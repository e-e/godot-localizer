<?php

namespace App\Interfaces;

/**
 * Interface PromptServiceInterface
 * @package App\Interfaces
 */
interface PromptServiceInterface
{
    /**
     * @param string $message
     * @return string
     */
    public function prompt(string $message) : string;
    
}
