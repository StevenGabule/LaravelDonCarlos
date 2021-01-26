<div class="row">

    @forelse($hotline_category as $cat)
        <div class="col-12 col-md-4 col-lg-12 pt-3">
            <h5 class="font-weight-bold">{{$cat->name}}:</h5>
            @forelse($cat->hotlines as $hotline)
                <div class="pl-4">
                    <a href="tel:{{$hotline->phone_number}}"
                       class="text-dark">
                        {{$hotline->phone_number}}</a>
                </div>
            @empty
                <span class="pl-4">No available phone number</span>
            @endforelse
        </div>
    @empty
    @endforelse

    {{--
    <div class="col-12 col-md-4 col-lg-12 pt-3">
        <h5 class="font-weight-bold">FIRE:</h5>
        <span class="pl-4"><a href="tel:20292929" class="text-dark">09236785946</a></span><br>
        <span class="pl-4"><a href="tel:20292929" class="text-dark">09236785946</a></span>
    </div>
    <div class="col-12 col-md-4 col-lg-12 pt-3">
        <h5 class="font-weight-bold">RESCUE:</h5>
        <span class="pl-4"><a href="tel:20292929" class="text-dark">09236785946</a></span><br>
        <span class="pl-4"><a href="tel:20292929" class="text-dark">09236785946</a></span>
    </div>--}}
</div>
