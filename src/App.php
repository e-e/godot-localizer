<?php

namespace App;

use App\Exceptions\InputFileArgumentException;
use App\Exceptions\OutputFileArgumentException;
use App\Interfaces\ParseServiceInterface;
use App\Interfaces\PromptServiceInterface;
use App\Interfaces\TranslationServiceInterface;

/**
 * @package App
 */
class App
{
    const ERROR_INPUT_REQUIRED = "An input CSV file path is required";
    const ERROR_INPUT_DOESNT_EXIST = "The input CSV file specified does not exist";
    const ERROR_OUTPUT_REQUIRED = "An output CSV file path is required";
    const ERROR_OUTPUT_NOT_OVERWRITING = "Not overwriting existing output file";

    /**
     * @var PromptServiceInterface $prompter
     */
    private $prompter;
    
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
     * @param PromptServiceInterface $prompter
     * @param ParseServiceInterface $parser
     * @param TranslationServiceInterface $translator
     */
    public function __construct(
        PromptServiceInterface $prompter,
        ParseServiceInterface $parser,
        TranslationServiceInterface $translator
    ) {
        $this->prompter = $prompter;
        $this->parser = $parser;
        $this->translator = $translator;
    }

    /**
     * @param string|null $inputFile
     * @param string|null $outputFile
     * @throws InputFileArgumentException
     * @throws OutputFileArgumentException
     */
    public function run(?string $inputFile = '', ?string $outputFile = '') : void
    {
        if (empty($inputFile)) {
            throw new InputFileArgumentException(self::ERROR_INPUT_REQUIRED);
        }
        
        if (!file_exists($inputFile)) {
            throw new InputFileArgumentException(self::ERROR_INPUT_DOESNT_EXIST);
        }
        
        if (empty($outputFile)) {
            throw new OutputFileArgumentException(self::ERROR_OUTPUT_REQUIRED);
        }
        
        if (file_exists($outputFile)) {
            $prompt = "\nA file at [$outputFile] already exists. Do you want to overwrite it? (y/n) ";
            $response = $this->getInput($prompt);
            
            while (!in_array($response, ["y", "n"])) {
                echo "\nI didn't catch that...";
                $response = $this->getInput($prompt);
            }
            
            if ($response === "n") {
                throw new OutputFileArgumentException(self::ERROR_OUTPUT_NOT_OVERWRITING);
            }
        }
        
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

    /**
     * @param string $prompt
     * @return string
     */
    private function getInput(string $prompt) : string
    {
        return $this->prompter->prompt($prompt);
    }
}
