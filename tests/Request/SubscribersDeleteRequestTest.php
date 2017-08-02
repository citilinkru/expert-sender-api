<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Tests\Request;

use Citilink\ExpertSenderApi\Enum\HttpMethod;
use Citilink\ExpertSenderApi\Request\SubscribersDeleteRequest;
use PHPUnit\Framework\Assert;

class SubscribersDeleteRequestTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateWithId()
    {
        $request = SubscribersDeleteRequest::createFromId(12, 25);
        Assert::assertEquals('', $request->toXml());
        Assert::assertEquals('/Api/Subscribers', $request->getUri());
        Assert::assertTrue($request->getMethod()->equals(HttpMethod::DELETE()));
        Assert::assertEquals(['id' => 12, 'listId' => 25], $request->getQueryParams());
    }

    public function testCreateWithEmail()
    {
        $request = SubscribersDeleteRequest::createFromEmail('mail@mail.com');
        Assert::assertEquals(['email' => 'mail@mail.com'], $request->getQueryParams());
    }
}
