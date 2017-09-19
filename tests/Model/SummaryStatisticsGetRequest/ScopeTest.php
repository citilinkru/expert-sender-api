<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Tests\Model\SummaryStatisticsGetRequest;

use Citilink\ExpertSenderApi\Enum\SummaryStatisticsGetRequest\MessageType;
use Citilink\ExpertSenderApi\Enum\SummaryStatisticsGetRequest\ReadingEnvironment;
use Citilink\ExpertSenderApi\Enum\SummaryStatisticsGetRequest\ScopeType;
use Citilink\ExpertSenderApi\Enum\SummaryStatisticsGetRequest\TimeOptimization;
use Citilink\ExpertSenderApi\Model\SummaryStatisticsGetRequest\Scope;

/**
 * ScopeTest
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class ScopeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test
     */
    public function testCreateList()
    {
        $scope = Scope::createList(123);
        $this->assertTrue(ScopeType::LIST()->equals($scope->getType()));
        $this->assertSame('123', $scope->getValue());
    }

    /**
     * Test
     */
    public function testCreateDomain()
    {
        $scope = Scope::createDomain('domain.com');
        $this->assertTrue(ScopeType::DOMAIN()->equals($scope->getType()));
        $this->assertSame('domain.com', $scope->getValue());
    }

    /**
     * Test
     */
    public function testCreateDomainFamily()
    {
        $scope = Scope::createDomainFamily('YAHOO');
        $this->assertTrue(ScopeType::DOMAIN_FAMILY()->equals($scope->getType()));
        $this->assertSame('YAHOO', $scope->getValue());
    }

    /**
     * Test
     */
    public function testCreateMessageType()
    {
        $scope = Scope::createMessageType(MessageType::NEWSLETTER());
        $this->assertTrue(ScopeType::MESSAGE_TYPE()->equals($scope->getType()));
        $this->assertSame(strval(MessageType::NEWSLETTER()), $scope->getValue());
    }

    /**
     * Test
     */
    public function testCreateIp()
    {
        $scope = Scope::createIp('127.0.0.1');
        $this->assertTrue(ScopeType::IP()->equals($scope->getType()));
        $this->assertSame('127.0.0.1', $scope->getValue());
    }

    /**
     * Test
     */
    public function testCreateSegment()
    {
        $scope = Scope::createSegment(123);
        $this->assertTrue(ScopeType::SEGMENT()->equals($scope->getType()));
        $this->assertSame('123', $scope->getValue());
    }

    /**
     * Test
     */
    public function testCreateVendor()
    {
        $scope = Scope::createVendor('vendor');
        $this->assertTrue(ScopeType::VENDOR()->equals($scope->getType()));
        $this->assertSame('vendor', $scope->getValue());
    }

    /**
     * Test
     */
    public function testCreateTag()
    {
        $scope = Scope::createTag('tag');
        $this->assertTrue(ScopeType::TAG()->equals($scope->getType()));
        $this->assertSame('tag', $scope->getValue());
    }

    /**
     * Test
     */
    public function testCreateSendTimeOptimization()
    {
        $scope = Scope::createSendTimeOptimization(TimeOptimization::NOT_USED());
        $this->assertTrue(ScopeType::SEND_TIME_OPTIMIZATION()->equals($scope->getType()));
        $this->assertSame(strval(TimeOptimization::NOT_USED()), $scope->getValue());
    }

    /**
     * Test
     */
    public function testCreateTimeTravelOptimization()
    {
        $scope = Scope::createTimeTravelOptimization(TimeOptimization::NOT_USED());
        $this->assertTrue(ScopeType::TIME_TRAVEL_OPTIMIZATION()->equals($scope->getType()));
        $this->assertSame(strval(TimeOptimization::NOT_USED()), $scope->getValue());
    }

    /**
     * Test
     */
    public function testCreateReadingEnvironment()
    {
        $scope = Scope::createReadingEnvironment(ReadingEnvironment::MOBILE());
        $this->assertTrue(ScopeType::READING_ENVIRONMENT()->equals($scope->getType()));
        $this->assertSame(strval(ReadingEnvironment::MOBILE()), $scope->getValue());
    }
}
