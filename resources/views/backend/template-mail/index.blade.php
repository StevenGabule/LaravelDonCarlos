@component('mail::message')
    # Hello {{ $data['name'] }},

    {{ $data['message'] }}

    Thanks,<br>
    Doncarlos.com
@endcomponent
