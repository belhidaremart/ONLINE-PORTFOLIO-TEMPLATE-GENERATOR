<div class="repeat-row">
    <div class="form-grid">
        @foreach($cfg['fields'] as $field => $label)
            <div class="{{ $field === 'description' ? 'full' : '' }}">
                <label>{{ $label }}</label>
                @if($field === 'description')
                    <textarea name="{{ $key }}[{{ $index }}][{{ $field }}]" rows="2">{{ $values[$field] ?? '' }}</textarea>
                @else
                    <input type="{{ $field === 'issued_on' ? 'date' : 'text' }}"
                           name="{{ $key }}[{{ $index }}][{{ $field }}]"
                           value="{{ $values[$field] ?? '' }}">
                @endif
            </div>
        @endforeach
    </div>
    <button type="button" class="btn btn-sm btn-danger remove-row">Remove</button>
</div>