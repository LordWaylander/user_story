<tr>
<td class="header">
@if (trim($slot) === 'ItSense')
<!--<img class="w-full" src="{{ URL::asset('images/itmunity.png') }}" alt="itmunity Logo">-->
<img class="w-full" src="https://www.itmunity.com/img/site/logo_itmunity.png" alt="itmunity logo">
@else
{{ $slot }}
@endif
</td>
</tr>
