<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Alibuya')
<img src="https://alibuya.net/api/public/images/logos/logo_300x64.png" class="logo" alt="Alibuya Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
