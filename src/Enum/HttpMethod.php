<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Enum;

use MyCLabs\Enum\Enum;

/**
 * HTTP methods
 *
 * @method static HttpMethod POST()
 * @method static HttpMethod GET()
 * @method static HttpMethod PUT()
 * @method static HttpMethod DELETE()
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
final class HttpMethod extends Enum
{
    /**
     * POST
     */
    const POST = 'POST';

    /**
     * GET
     */
    const GET = 'GET';

    /**
     * PUT
     */
    const PUT = 'PUT';

    /**
     * DELETE
     */
    const DELETE = 'DELETE';
}
