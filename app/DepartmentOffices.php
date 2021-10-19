<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DepartmentOffices extends Model
{
    protected $guarded = [];
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function department_categories(): BelongsTo
    {
        return $this->belongsTo(DepartmentCategories::class, 'department_category_id');
    }
}
