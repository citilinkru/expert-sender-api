<?php
namespace LinguaLeo\ExpertSender\Chunks;

use LinguaLeo\ExpertSender\ExpertSenderResponse;

class ExpertSenderResponseTest extends \PHPUnit_Framework_TestCase
{
    CONST ERROR = <<<EOD
<ApiResponse xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
    <ErrorMessage>
        <Code>401</Code>
        <Message>Email is invalid</Message>
    </ErrorMessage>
</ApiResponse>
EOD;

    public function testGetErrorMessage()
    {
        $response = new ExpertSenderResponse(self::ERROR, 200);

        $this->assertEquals('Email is invalid', $response->getErrorMessage());
        $this->assertEquals(401, $response->getErrorCode());
        $this->assertEquals(200, $response->getResponseCode());
        $this->assertEquals(false, $response->isOk());
    }
}
