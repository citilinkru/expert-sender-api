<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Response;

use Citilink\ExpertSenderApi\Model\SegmentsGetResponse\Segment;
use Citilink\ExpertSenderApi\SpecificXmlMethodResponse;

/**
 * Segments GET response
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class SegmentsGetResponse extends SpecificXmlMethodResponse
{
    /**
     * Get segments
     *
     * @return Segment[] Segments
     */
    public function getSegments(): array
    {
        $nodes = $this->getSimpleXml()->xpath('/ApiResponse/Data/Segments/Segment');
        $segments = [];
        foreach ($nodes as $node) {
            $segments[] = new Segment(
                (int)$node->Id,
                (string)$node->Name
            );
        }

        return $segments;
    }
}
