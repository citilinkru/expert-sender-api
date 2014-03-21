<?php

namespace LinguaLeo\ExpertSender\Results;

use LinguaLeo\ExpertSender\ApiResult;

class TableDataResult extends ApiResult
{

    /** @var array */
    protected $data;

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
        $this->data = explode("\n", $this->response->getBody());
        if ($this->data) {
            unset($this->data[0]);
        }
        $this->data = array_filter($this->data, function($e) { return !empty($e); });
        $this->data = array_map(function($e){ return str_getcsv($e); }, $this->data);
        $this->data = array_values($this->data);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

} 