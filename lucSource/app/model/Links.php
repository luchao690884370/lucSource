<?php

namespace plugin\lucSource\app\model;

use plugin\admin\app\model\Base;

class Links  extends  Base
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'luc_links';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';
}