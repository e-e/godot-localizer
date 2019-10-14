<?php

namespace App;

use App\Interfaces\ParseServiceInterface;
use App\Interfaces\TranslationServiceInterface;

/**
 * @package App
 */
class App
{
    /**
     * @var ParseServiceInterface $parser
     */
    private $parser;

    /**
     * TranslationServiceInterface $translator
     */
    private $translator;

    /**
     * App constructor.
     * @param ParseServiceInterface $parser
     * @param TranslationServiceInterface $translator
     */
    public function __construct(ParseServiceInterface $parser, TranslationServiceInterface $translator)
    {
        $this->parser = $parser;
        $this->translator = $translator;
    }

    /**
     * @param string $inputFile
     * @param string $outputFile
     */
    public function run(string $inputFile, string $outputFile) : void
    {
        $data = $this->parser->parse($inputFile);
        $translated = $this->translateAll($data);

        $this->parser->unparse($translated, $outputFile);
    }

    /**
     * @param $data
     * @return mixed
     */
    private function translateAll($data)
    {
        foreach ($data as $index => $row) {
            $english = $row['en'];

            foreach ($row as $_key => $value) {
                if (in_array($_key, ['id', 'en'])) {
                    continue;
                }

                $data[$index][$_key] = $this->translator->translate('en', $_key, $english);
            }
        }

        return $data;
    }
}
