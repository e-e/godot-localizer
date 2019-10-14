<?php

namespace App;

use App\Exceptions\InputFileArgumentException;
use App\Exceptions\OutputFileArgumentException;
use App\Interfaces\ParseServiceInterface;
use App\Interfaces\PromptServiceInterface;
use App\Interfaces\TranslationServiceInterface;
use Mockery as m;
use Mockery\MockInterface;

require_once "AbstractTestCase.php";

/**
 * Class AppTest
 * @package App\Services
 */
class AppTest extends AbstractTestCase
{
    /**
     * @var PromptServiceInterface|MockInterface $prompterService
     */
    private $prompterService;
    
    /**
     * @var ParseServiceInterface|MockInterface
     */
    private $parseService;

    /**
     * @var TranslationServiceInterface|MockInterface
     */
    private $translateService;
    
    public function setUp(): void
    {
        parent::setUp();
        $this->prompterService = m::mock(PromptServiceInterface::class);
        $this->parseService = m::mock(ParseServiceInterface::class);
        $this->translateService = m::mock(TranslationServiceInterface::class);
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

    public function testRunNoInputFile()
    {
        $this->expectException(InputFileArgumentException::class);
        $this->expectExceptionMessage(App::ERROR_INPUT_REQUIRED);
        
        $service = $this->getClass();
        $service->run('', '');
    }

    public function testRunInputFileDoesntExist()
    {
        $this->expectException(InputFileArgumentException::class);
        $this->expectExceptionMessage(App::ERROR_INPUT_DOESNT_EXIST);
        
        $inputFile = '/test/input.csv';
        
        self::$functions->shouldReceive('file_exists')
            ->with($inputFile)
            ->andReturn(false)
            ->once();

        $service = $this->getClass();
        $service->run($inputFile, '');
    }

    public function testRunNoOutputFile()
    {
        $this->expectException(OutputFileArgumentException::class);
        $this->expectExceptionMessage(App::ERROR_OUTPUT_REQUIRED);

        $inputFile = '/test/input.csv';
        $outputFile = '';

        self::$functions->shouldReceive('file_exists')
            ->with($inputFile)
            ->andReturn(true)
            ->once();

        $service = $this->getClass();
        $service->run($inputFile, $outputFile);
    }

    public function testRunOutputFileExists()
    {
        $this->expectException(OutputFileArgumentException::class);
        $this->expectExceptionMessage(App::ERROR_OUTPUT_NOT_OVERWRITING);

        $inputFile = '/test/input.csv';
        $outputFile = '/test/output.csv';

        self::$functions->shouldReceive('file_exists')
            ->with($inputFile)
            ->andReturn(true)
            ->once();

        self::$functions->shouldReceive('file_exists')
            ->with($outputFile)
            ->andReturn(true)
            ->once();
        
        $this->prompterService
            ->shouldReceive('prompt')
            ->with(
                m::type('string')
            )
            ->andReturn('sldkjf', 'n')
            ->twice();
        
        $this->parseService
            ->shouldReceive('parse')
            ->never();
        
        $service = $this->getClass();
        $service->run($inputFile, $outputFile);
    }

    public function testRun()
    {
        $inputFile = '/test/input.csv';
        $outputFile = '/test/output.csv';

        $enInput = 'Hello';
        $parsed = [
            ['id' => 'GREETING', 'en' => $enInput, 'ja' => '', 'de' => ''],
        ];
        
        
        $jaOutput = 'こんにちは';
        $deOutput = 'Hallo';
        $translated = [
            ['id' => 'GREETING', 'en' => $enInput, 'ja' => $jaOutput, 'de' => $deOutput],
        ];

        self::$functions->shouldReceive('file_exists')
            ->with($inputFile)
            ->andReturn(true)
            ->once();

        self::$functions->shouldReceive('file_exists')
            ->with($outputFile)
            ->andReturn(true)
            ->once();

        $this->prompterService
            ->shouldReceive('prompt')
            ->with(
                m::type('string')
            )
            ->andReturn('y')
            ->once();

        $this->parseService
            ->shouldReceive('parse')
            ->with($inputFile)
            ->andReturn($parsed)
            ->once();
        
        $this->translateService
            ->shouldReceive('translate')
            ->with('en', 'ja', $enInput)
            ->andReturn($jaOutput)
            ->once();

        $this->translateService
            ->shouldReceive('translate')
            ->with('en', 'de', $enInput)
            ->andReturn($deOutput)
            ->once();
        
        $this->parseService
            ->shouldReceive('unparse')
            ->with(
                $translated,
                $outputFile
            )
            ->once();

        $service = $this->getClass();
        $service->run($inputFile, $outputFile);
    }

    /**
     * @return App
     */
    public function getClass() : App
    {
        return new App(
            $this->prompterService,
            $this->parseService,
            $this->translateService
        );
    }
}
