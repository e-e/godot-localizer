<?php

namespace App\Services;

use Google\Cloud\Translate\TranslateClient;
use Mockery as m;
use Mockery\MockInterface;

require_once "AbstractTestCase.php";

/**
 * Class GoogleTranslateServiceTest
 * @package App\Services
 */
class GoogleTranslateServiceTest extends AbstractTestCase
{
    /**
     * @var TranslateClient|MockInterface $client
     */
    private $client;

    public function setUp(): void
    {
        parent::setUp();
        
        self::$functions = m::mock();
        $this->client = m::mock(TranslateClient::class);
    }

    public function tearDown(): void
    {
        parent::tearDown();

        if ($container = m::getContainer()) {
            $this->addToAssertionCount($container->mockery_getExpectationCount());
        }

        m::close();
    }

    public function testTranslate()
    {
        $text = 'Test English Text';
        $fromCode = 'en';
        $targetCode = 'ja';
        $expected = 'テストの英語テキスト';
        $codes = [
            'source' => $fromCode,
            'target' => $targetCode,
        ];
        $response = [
            'text' => $expected,
        ];
        $this->client
            ->shouldReceive('translate')
            ->with(
                $text,
                $codes
            )
            ->andReturn($response);
        
        $service = $this->getService();
        $actual = $service->translate($fromCode, $targetCode, $text);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @return GoogleTranslateService
     */
    public function getService() : GoogleTranslateService
    {
        return new GoogleTranslateService(
            $this->client
        );
    }
}
