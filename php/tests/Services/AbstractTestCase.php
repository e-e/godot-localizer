<?php

namespace App\Services;

use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

/**
 * @param $handle
 * @return mixed
 */
function fclose($handle)
{
    return AbstractTestCase::$functions->fclose($handle);
}

/**
 * @param $contents
 * @return mixed
 */
function fgetcsv($contents)
{
    return AbstractTestCase::$functions->fgetcsv($contents);
}

/**
 * @param string $filepath
 * @return bool
 */
function file_exists(string $filepath) : bool
{
    return AbstractTestCase::$functions->file_exists($filepath);
}

/**
 * @param string $filepath
 * @param string $contents
 * @return mixed
 */
function file_put_contents(string $filepath, string $contents)
{
    return AbstractTestCase::$functions->file_put_contents($filepath, $contents);
}

/**
 * @param string $filepath
 * @param string $mode
 * @return resource
 */
function fopen(string $filepath, string $mode = 'r')
{
    return AbstractTestCase::$functions->fopen($filepath, $mode);
}

/**
 * @param string $filepath
 * @return bool
 */
function is_readable(string $filepath) : bool
{
    return AbstractTestCase::$functions->is_readable($filepath);
}

/**
 * Class AbstractTestCase
 * @package App
 */
abstract class AbstractTestCase extends TestCase
{
    /**
     * @var MockInterface $functions
     */
    public static $functions;
}
