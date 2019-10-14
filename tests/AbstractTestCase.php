<?php

namespace App;

use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

/**
 * @param string $filepath
 * @return bool
 */
function file_exists(string $filepath) : bool
{
    return AbstractTestCase::$functions->file_exists($filepath);
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
