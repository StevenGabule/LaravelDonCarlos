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

    public function display_image(): string
    {
      return $this->avatar !== null ? asset($this->avatar) : asset('assets/images/photo-1558449033-7ae045d2c81a.jfif');
    }

  }
