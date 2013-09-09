<?php
//

namespace LinguaLeo\ExpertSender\Chunks;

use LinguaLeo\ExpertSender\ExpertSenderResponse;

class ExpertSenderResponseTest extends \PHPUnit_Framework_TestCase
{
    CONST ERROR = <<<EOD
<ApiResponse xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
    <ErrorMessage>
        <Code>400</Code>
        <Message>Email is invalid</Message>
    </ErrorMessage>
</ApiResponse>
EOD;

    public function testGetErrorMessage()
    {
        $response = new ExpertSenderResponse(self::ERROR, 200);

        $message = $response->getErrorMessage();

        $this->assertSame('Email is invalid', $message);
    }
}
