<?php

namespace Novu\SDK\Resources;

/**
 * @template T
 */
class Paginated
{
    public $page;
    public $pageSize;
    public $totalCount;
    /**
     * @var T[]
     */
    public array $data;

    public function __construct($data)
    {
        $this->data = $data['data'];
        $this->page = $data['page'];
        $this->pageSize = $data['pageSize'];
        $this->totalCount = $data['totalCount'];
    }
}
