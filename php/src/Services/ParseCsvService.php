<?php

namespace App\Services;

use App\Exceptions\ParseException;
use App\Interfaces\ParseServiceInterface;

/**
 * Class ParseCsvService
 * @package App\Services
 */
class ParseCsvService implements ParseServiceInterface
{
    const GODOT_CODE_MAP = [
        "no" => "nb",
    ];

    /**
     * @var array|null
     */
    private $languageMap;

    /**
     * ParseCsvService constructor.
     * @param array $languageMap
     */
    public function __construct(array $languageMap = [])
    {
        if (!empty($languageMap)) {
            $this->languageMap = $languageMap;
        }
    }

    /**
     * @param string $filename
     * @param string $delimiter
     * @return array
     * @throws ParseException
     */
    public function parse(string $filename, string $delimiter = ",") : array
    {
        if(!file_exists($filename) || !is_readable($filename)) {
            throw new ParseException("Unable to parse input file");
        }
    
        $header = null;
        $data = array();
    
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if(!$header) {
                    $header = $row;
                } else {
                    $data[] = array_combine($header, $row);
                }
            }
            
            fclose($handle);
        }

        return $data;
    }

    /**
     * @inheritDoc
     */
    public function unparse(array $data, string $outputFilepath) : void
    {
        $headers = array_keys($data[0]);

        $convertedHeaders = $this->convertHeaders($headers);
        $csv = implode(",", $convertedHeaders) . "\n";

        foreach ($data as $row) {
            $rowString = "";

            foreach ($headers as $column) {
                $rowString .= $row[$column] . ",";
            }

            $rowString = preg_replace("/,$/", "", $rowString);

            $rowString .= "\n";

            $csv .= $rowString;
        }

        file_put_contents($outputFilepath, $csv);
    }

    /**
     * @param array $headers
     * @return array
     */
    private function convertHeaders(array $headers) : array
    {
        if (empty($this->languageMap)) {
            return $headers;
        }
        
        $converted = [];

        foreach ($headers as $column) {
            $converted[] = $this->languageMap[$column] ?? $column;
        }

        return $converted;
    }
}
