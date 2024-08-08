@props(['messages'])

@if(isset($messages) && is_array($messages) && count ($messages) > 0)
<div class="invalid-feedback d-block m-0">
    {{ $messages[0] }}
</div>
@endif