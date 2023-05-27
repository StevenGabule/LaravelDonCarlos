<?php

  namespace App;

  use Illuminate\Database\Eloquent\Model;

  /**
   * App\PageContent
   *
   * @property int $id
   * @property string $title
   * @property string $short_description
   * @property string $slug
   * @property string $description
   * @property int $views
   * @property string|null $avatar
   * @property int $is_live
   * @property int $upload_successful
   * @property string $disk
   * @property \Illuminate\Support\Carbon|null $created_at
   * @property \Illuminate\Support\Carbon|null $updated_at
   * @method static \Illuminate\Database\Eloquent\Builder|\App\PageContent newModelQuery()
   * @method static \Illuminate\Database\Eloquent\Builder|\App\PageContent newQuery()
   * @method static \Illuminate\Database\Eloquent\Builder|\App\PageContent query()
   * @method static \Illuminate\Database\Eloquent\Builder|\App\PageContent whereAvatar($value)
   * @method static \Illuminate\Database\Eloquent\Builder|\App\PageContent whereCreatedAt($value)
   * @method static \Illuminate\Database\Eloquent\Builder|\App\PageContent whereDescription($value)
   * @method static \Illuminate\Database\Eloquent\Builder|\App\PageContent whereDisk($value)
   * @method static \Illuminate\Database\Eloquent\Builder|\App\PageContent whereId($value)
   * @method static \Illuminate\Database\Eloquent\Builder|\App\PageContent whereIsLive($value)
   * @method static \Illuminate\Database\Eloquent\Builder|\App\PageContent whereShortDescription($value)
   * @method static \Illuminate\Database\Eloquent\Builder|\App\PageContent whereSlug($value)
   * @method static \Illuminate\Database\Eloquent\Builder|\App\PageContent whereTitle($value)
   * @method static \Illuminate\Database\Eloquent\Builder|\App\PageContent whereUpdatedAt($value)
   * @method static \Illuminate\Database\Eloquent\Builder|\App\PageContent whereUploadSuccessful($value)
   * @method static \Illuminate\Database\Eloquent\Builder|\App\PageContent whereViews($value)
   * @mixin \Eloquent
   */
  class PageContent extends Model
  {
    protected $guarded = [];

    public function display_image(): string
    {
      return $this->avatar !== null ? asset($this->avatar) : asset('assets/images/photo-1558449033-7ae045d2c81a.jfif');
    }

  }
