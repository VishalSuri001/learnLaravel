@component('mail::message')
# introduction
Reservation for {{ $name }}.

{{-- @component('mail:button', ['url'=> ''])
    Button Text
@endcomponent --}}
    
Thanks, <br/>
{{ config('app.name') }}
@endcomponent