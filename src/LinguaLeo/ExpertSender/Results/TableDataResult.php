<?php

namespace LinguaLeo\ExpertSender\Results;

use LinguaLeo\ExpertSender\ApiResult;

class TableDataResult extends ApiResult
{

    /** @var array */
    protected $data = [];

    /**
     * @param \LinguaLeo\ExpertSender\ExpertSenderResponse $response
     */
    public function __construct($response)
    {
        parent::__construct($response);
        $this->parse();
    }

    protected function parse()
    {
        if (!$this->response->isOk()) {
            return;
        }
        $temp = tmpfile();
        fwrite($temp, $this->response->getBody());
        fseek($temp, 0);
        while (($row = fgetcsv($temp)) !== false) {
            $this->data[] = $row;
        }
        fclose($temp);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

} 