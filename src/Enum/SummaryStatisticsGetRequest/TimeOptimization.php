<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Enum\SummaryStatisticsGetRequest;

use MyCLabs\Enum\Enum;

/**
 * Time optimization setting
 *
 * @method static TimeOptimization OPTIMIZED()
 * @method static TimeOptimization NOT_OPTIMIZED()
 * @method static TimeOptimization NOT_USED()
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
final class TimeOptimization extends Enum
{
    /**
     * Time optimized
     */
    const OPTIMIZED = 'TimeOptimized';

    /**
     * Time not optimized
     */
    const NOT_OPTIMIZED = 'TimeNotOptimized';

    /**
     * Optimization not used
     */
    const NOT_USED = 'OptimizationNotUsed';
}
