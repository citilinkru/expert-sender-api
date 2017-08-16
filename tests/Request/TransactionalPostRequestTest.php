<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Tests\Request;

use Citilink\ExpertSenderApi\Model\TransactionalPostRequest\Attachment;
use Citilink\ExpertSenderApi\Model\TransactionalPostRequest\Receiver;
use Citilink\ExpertSenderApi\Model\TransactionalPostRequest\Snippet;
use Citilink\ExpertSenderApi\Enum\HttpMethod;
use Citilink\ExpertSenderApi\Request\TransactionalPostRequest;

class TransactionalPostRequestTest extends \PHPUnit_Framework_TestCase
{
    public function testRequestCompileValidXml()
    {
        $request = new TransactionalPostRequest(
            12,
            Receiver::createWithEmail('email@email.com'),
            [
                new Snippet('snippet1', 23),
                new Snippet('snippet2', 'string'),
                new Snippet('snippet3', 23.4),
                new Snippet('snippet4', '<b>html</b>'),

            ],
            [
                new Attachment('filename.pdf', base64_encode('data'), 'application/pdf'),
                new Attachment('image.jpg', base64_encode('image'), 'image/jpeg'),
            ],
            true
        );

        $this->assertEquals(
            '<Data><Receiver><Email>email@email.com</Email></Receiver><Snippets><Snippet><Name>snippet1</Name>'
            . '<Value>23</Value></Snippet><Snippet><Name>snippet2</Name><Value>string</Value></Snippet><Snippet>'
            . '<Name>snippet3</Name><Value>23.4</Value></Snippet><Snippet><Name>snippet4</Name>'
            . '<Value><![CDATA[<b>html</b>]]></Value></Snippet></Snippets><Attachments><Attachment>'
            . '<FileName>filename.pdf</FileName><Content>ZGF0YQ==</Content><MimeType>application/pdf</MimeType>'
            . '</Attachment><Attachment><FileName>image.jpg</FileName><Content>aW1hZ2U=</Content>'
            . '<MimeType>image/jpeg</MimeType></Attachment></Attachments><ReturnGuid>true</ReturnGuid></Data>',
            $request->toXml()
        );
        $this->assertTrue($request->getMethod()->equals(HttpMethod::POST()));
        $this->assertCount(0, $request->getQueryParams());
        $this->assertEquals('/Api/Transactionals/12', $request->getUri());
    }

    public function testRequestWithAnyReceiverCompileValidXml()
    {
        $request = new TransactionalPostRequest(12, Receiver::createWithId(12, 25));
        $this->assertEquals(
            '<Data><Receiver><Id>12</Id><ListId>25</ListId></Receiver></Data>',
            $request->toXml()
        );

        $request2 = new TransactionalPostRequest(12, Receiver::createWithEmail('mail@mail.com'));
        $this->assertEquals(
            '<Data><Receiver><Email>mail@mail.com</Email></Receiver></Data>',
            $request2->toXml()
        );

        $request3 = new TransactionalPostRequest(12, Receiver::createWithEmailMd5(md5('mail@mail.com')));
        $this->assertEquals(
            '<Data><Receiver><EmailMd5>7905d373cfab2e0fda04b9e7acc8c879</EmailMd5></Receiver></Data>',
            $request3->toXml()
        );
    }
}
