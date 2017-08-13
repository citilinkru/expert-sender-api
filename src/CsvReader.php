<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi;

use Webmozart\Assert\Assert;

/**
 * Csv reader
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class CsvReader
{
    /**
     * @var resource Stream
     */
    private $stream;

    /**
     * Constructor.
     *
     * @param resource $stream Stream
     */
    public function __construct($stream)
    {
        Assert::resource($stream);
        rewind($stream);
        $this->stream = $stream;
    }

    /**
     * Get Rows as associative arrays, where keys are column names
     *
     * @return iterable Rows as associative arrays, where keys are column names
     */
    public function fetchAll(): iterable
    {
        // pass header
        $columnNames = fgetcsv($this->stream);

        // read line by line
        while (($row = fgetcsv($this->stream)) !== false) {
            // empty line protection, empty line equals [0 => null], and isset on null values always return false
            if (!isset($row[0])) {
                continue;
            }

            // convert to assoc array
            $assocRow = [];
            foreach ($columnNames as $index => $columnName) {
                $assocRow[$columnName] = $row[$index];
            }

            yield $assocRow;
        }
    }
}