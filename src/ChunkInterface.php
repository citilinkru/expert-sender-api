<?php

namespace Citilink\ExpertSenderApi;

/**
 * Chunk of request
 *
 * @deprecated Do not use it, this interface will be deleted soon
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
interface ChunkInterface
{
    /**
     * Get xml representation of chunk
     *
     * @return string Xxml representation of chunk
     */
    public function toXml(): string;
} 
