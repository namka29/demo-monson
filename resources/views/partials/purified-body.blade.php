@php
    use Stevebauman\Purify\Facades\Purify;
@endphp
{!! Purify::clean($html ?? '') !!}
