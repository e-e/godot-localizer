<?php

namespace App\Services;

use App\Exceptions\ParseException;
use Mockery as m;

require_once "AbstractTestCase.php";

/**
 * Class ParseCsvServiceTest
 * @package App\Services
 */
class ParseCsvServiceTest extends AbstractTestCase
{
    /**
     * @var array|null $langCodeMap
     */
    private $langCodeMap = [];
    
    public function setUp(): void
    {
        parent::setUp();
        self::$functions = m::mock();
    }

    public function tearDown(): void
    {
        parent::tearDown();

        if ($container = m::getContainer()) {
            $this->addToAssertionCount($container->mockery_getExpectationCount());
        }

        m::close();
    }
    
    public function testParseFileDoesntExist()
    {
        $this->expectException(ParseException::class);
        
        $inputFile = '/test/input.csv';
        
        self::$functions->shouldReceive('file_exists')
            ->with($inputFile)
            ->andReturn(false)
            ->once();
        
        $service = $this->getService();
        $service->parse($inputFile);
    }
    
    public function testParseFileIsNotReadable()
    {
        $this->expectException(ParseException::class);
        
        $inputFile = '/test/input.csv';

        self::$functions->shouldReceive('file_exists')
            ->with($inputFile)
            ->andReturn(true)
            ->once();

        self::$functions->shouldReceive('is_readable')
            ->with($inputFile)
            ->andReturn(false)
            ->once();

        $service = $this->getService();
        $service->parse($inputFile);
    }
    
    public function testParse()
    {
        $inputFile = '/test/input.csv';

        self::$functions->shouldReceive('file_exists')
            ->with($inputFile)
            ->andReturn(true)
            ->once();

        self::$functions->shouldReceive('is_readable')
            ->with($inputFile)
            ->andReturn(true)
            ->once();
        
        $handle = m::type('resource');
        self::$functions
            ->shouldReceive('fopen')
            ->with($inputFile, 'r')
            ->andReturn($handle)
            ->once();
        
        $header = ['id', 'en', 'de'];
        $row = ['GREETING', 'Hello', ''];
        
        self::$functions
            ->shouldReceive('fgetcsv')
            ->with($handle)
            ->andReturn($header, $row, false)
            ->times(3);
        
        self::$functions
            ->shouldReceive('fclose')
            ->with($handle)
            ->once();

        $service = $this->getService();
        $service->parse($inputFile);
    }

    /**
     * @return ParseCsvService
     */
    public function getService() : ParseCsvService
    {
        return new ParseCsvService($this->langCodeMap);
    }
}
