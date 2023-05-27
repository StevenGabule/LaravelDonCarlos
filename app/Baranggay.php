<?php

  namespace App;

  use Carbon\Carbon;
  use Illuminate\Database\Eloquent\Model;
  use Illuminate\Database\Eloquent\Relations\HasMany;
  use Illuminate\Database\Eloquent\SoftDeletes;

  class Baranggay extends Model
  {
    protected $guarded = [];
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function baranggay_officials(): HasMany
    {
      $dt = Carbon::now();
      return $this->hasMany(BaranggayOfficial::class)->whereBetween('from', [$dt->year, $dt->year + 1]);
    }

    public function scopeFilter($query, $filter): void
    {
      if (isset($filter['q']) && $term = strtolower($filter['q'])) {
        $query->where(static function ($q) use ($term) {
          $q->orwhereRaw('LOWER(name) LIKE ?', ["%{$term}%"]);
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
