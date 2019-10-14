<?php

namespace App\Interfaces;

/**
 * Interface ParseServiceInterface
 * @package App\Interfaces
 */
interface ParseServiceInterface
{
    /**
     * @param string $filename
     * @return array
     */
    public function parse(string $filename) : array;

    /**
     * @param array $data
     * @param string $filename
     */
    public function unparse(array $data, string $filename) : void;
}
