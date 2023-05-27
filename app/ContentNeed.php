<?php

  namespace App;

  use Illuminate\Database\Eloquent\{Model, SoftDeletes};

  class ContentNeed extends Model
  {
    protected $guarded = [];
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function scopeFilter($query, $filter): void
    {
      if (isset($filter['q']) && $term = strtolower($filter['q'])) {
        $query->where(static function ($q) use ($term) {
          $q->orwhereRaw('LOWER(title) LIKE ?', ["%{$term}%"]);
          $q->orwhereRaw('LOWER(short_description) LIKE ?', ["%{$term}%"]);
          $q->orwhereRaw('LOWER(description) LIKE ?', ["%{$term}%"]);
        });
      }
    }

    public function display_image(): string
    {
      return $this->avatar !== null ? asset($this->avatar) : asset('assets/images/photo-1558449033-7ae045d2c81a.jfif');
    }

  }
