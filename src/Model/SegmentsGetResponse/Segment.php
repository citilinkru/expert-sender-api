<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Model\SegmentsGetResponse;

/**
 * Segment
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class Segment
{
    /**
     * @var int Identifier
     */
    private $id;

    /**
     * @var string Name
     */
    private $name;

    /**
     * Constructor.
     *
     * @param int $id Identifier
     * @param string $name Name
     */
    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * Get identifier
     *
     * @return int Identifier
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get name
     *
     * @return string Name
     */
    public function getName(): string
    {
        return $this->name;
    }
}
