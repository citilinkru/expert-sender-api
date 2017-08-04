<?php

namespace Citilink\ExpertSenderApi\Response;

use Citilink\ExpertSenderApi\ResponseInterface;
use Citilink\ExpertSenderApi\SpecificXmlMethodResponse;

/**
 * Table data response
 *
 * @deprecated Do not use it, this class will be deleted soon.
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class TableDataResponse extends SpecificXmlMethodResponse
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * Constructor
     *
     * @param ResponseInterface $response Response of ExpertSender API
     */
    public function __construct(ResponseInterface $response)
    {
        parent::__construct($response);
        $this->parse();
    }

    protected function parse()
    {
        $response = $this->removeBOM($this->response->getContent());
        if (!$this->response->isOk() || !$response) {
            return;
        }
        $temp = tmpfile();
        fwrite($temp, $response);
        fseek($temp, 0);
        while (($row = fgetcsv($temp)) !== false) {
            $this->data[] = $row;
        }
        fclose($temp);
    }

    /**
     * @param string $text
     * @return string
     */
    private function removeBOM($text)
    {
        $bom = pack('H*','EFBBBF');
        return preg_replace("/^{$bom}/", '', $text);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

} 
