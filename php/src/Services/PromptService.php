<?php

namespace App\Services;

use App\Interfaces\PromptServiceInterface;

/**
 * Class PromptService
 * @package App\Services
 */
class PromptService implements PromptServiceInterface
{
    /**
     * @param string $message
     * @return string
     */
    public function prompt(string $message): string
    {
        echo $message;
        return rtrim(fgets(STDIN));
    }
}
