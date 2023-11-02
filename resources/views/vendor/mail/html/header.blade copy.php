@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="{{ url(DiligentCreators('site_logo')) }}" class="logo" alt="{{ DiligentCreators('site_name') }}">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
