@foreach($articles as $article)
    <div class="col-12 pt-3 ">
        <div class="card bg-light shadow-sm border-0 ">
            <div>
                <!-- recomendedd landscape image to prevent bluring in when changing screen size -->
                <img class="card-img max-height-150"
                     src="{{ $article->avatar ? asset('/backend/uploads/articles/'.$article->avatar) : asset('assets/icons/images.svg') }}"
                     alt="Announcement Images ">
            </div>
            <div class="card-body ">
                <h6 class="card-title font-weight-bold ">
                    <a href="{{ route('news.detail', ['slug' => $article->slug]) }}" class="text-dark">{{ $article->created }} : {{ $article->display_data($article->title, 50) }}</a>
                </h6>
                <p class="card-text ">
                    {{ $article->display_data($article->short_description, 140) }}
                </p>
                <a href="{{ route('news.detail', ['slug' => $article->slug]) }}"
                   class="btn btn-outline-gold px-4 py-1 rounded-0">
                    <small>More Info</small>
                </a>
            </div>
        </div>
    </div>
@endforeach
