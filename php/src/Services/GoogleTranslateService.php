<?php

namespace App\Services;

use App\Interfaces\TranslationServiceInterface;
use Google\Cloud\Translate\TranslateClient;

/**
 * Class GoogleTranslateService
 * @package App\Services
 */
class GoogleTranslateService implements TranslationServiceInterface
{
    /**
     * @var TranslateClient $client
     */
    private $client;

    /**
     * GoogleTranslateService constructor.
     * @param TranslateClient $client
     */
    public function __construct(TranslateClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $fromCode
     * @param string $targetCode
     * @param string $text
     * @return string
     */
    public function translate(string $fromCode, string $targetCode, string $text) : string
    {
        $translation = $this->client->translate($text, [
            'source' => $fromCode,
            'target' => $targetCode,
        ]);
        
        return $translation['text'] ?? '';
    }
}
