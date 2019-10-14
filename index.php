<?php

require_once "vendor/autoload.php";

use App\App;
use App\Exceptions\InputFileArgumentException;
use App\Exceptions\OutputFileArgumentException;
use App\Services\GoogleTranslateService;
use App\Services\ParseCsvService;
use App\Services\PromptService;
use Dotenv\Dotenv;
use Google\Cloud\Translate\TranslateClient;

$dotenv = Dotenv::create(__DIR__);
$dotenv->load();

$prompter = new PromptService;

$languageCodeMap = file_exists("./lang-codes.php")
    ? require_once "./lang-codes.php"
    : [];
$parser = new ParseCsvService($languageCodeMap);

$client = new TranslateClient([
    'keyFilePath' => getenv('GOOGLE_TRANSLATE_KEYFILE_PATH'),
]);
$translator = new GoogleTranslateService($client);

$app = new App(
    $prompter,
    $parser,
    $translator
);

try {
    $app->run(
        $inputFile = $argv[1],
        $outputFile = $argv[2]
    );
} catch (InputFileArgumentException $e) {
    echo "\n{$e->getMessage()}\n";
} catch (OutputFileArgumentException $e) {
    echo "\n{$e->getMessage()}\n";
} catch (Throwable $e) {
    echo "Something went wrong...";
    
    if (getenv("DEV_MODE") === true) {
        echo "\n" . (string)$e;
    }
}
