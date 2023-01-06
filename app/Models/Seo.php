<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    protected $table = 'seo';

    const UNDER_GRAD_PAGE = 10;
    const GRAD_PAGE = 20;
    const MS_PAGE = 30;
    const PHD_PAGE = 40;
    const GRAD_LOC_PAGE = 50;
    const TOP_PAGE = 60;
    const CHEAPEST_PAGE = 70;
    const TOP_UNDER_GRAD_PAGE = 80;
    const COMPARE_PAGE = 90;

    public function seoable()
    {
        return $this->morphTo();
    }
}
