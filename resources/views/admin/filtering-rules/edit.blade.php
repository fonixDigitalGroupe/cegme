@extends('admin.layout')

@section('title', 'Modifier une règle de filtrage')

@section('content')
<div style="margin-bottom: 1.5rem;">
    <h1 style="font-size: 1.5rem; font-weight: 600; color: #1a1a1a; margin: 0;">Modifier une règle de filtrage</h1>
</div>

@if($errors->any())
    <div style="padding: 1rem; background-color: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; border-radius: 4px; margin-bottom: 1.5rem;">
        <ul style="margin: 0; padding-left: 1.5rem;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('admin.filtering-rules.update', $filteringRule) }}" style="background-color: #ffffff; padding: 1.5rem; border: 1px solid #d1d5db; border-radius: 4px;">
    @csrf
    @method('PUT')

    <div style="margin-bottom: 1.5rem;">
        <label for="name" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">Nom de la règle *</label>
        <input type="text" id="name" name="name" value="{{ old('name', $filteringRule->name) }}" required style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 4px; font-size: 0.875rem;">
    </div>

    <div style="margin-bottom: 1.5rem;">
        <label for="source" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">Source *</label>
        <select id="source" name="source" required style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 4px; font-size: 0.875rem;">
            @foreach($sources as $source)
                <option value="{{ $source }}" {{ old('source', $filteringRule->source) === $source ? 'selected' : '' }}>{{ $source }}</option>
            @endforeach
        </select>
    </div>



    <div style="margin-bottom: 1.5rem;">
        <label style="display: flex; align-items: center; cursor: pointer;">
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $filteringRule->is_active) ? 'checked' : '' }} style="margin-right: 0.5rem;">
            <span style="font-size: 0.875rem; font-weight: 500; color: #374151;">Règle active</span>
        </label>
    </div>

    <div style="display: flex; gap: 0.5rem;">
        <button type="submit" style="padding: 0.625rem 1.25rem; background-color: #00C853; color: white; border: none; border-radius: 4px; font-weight: 500; cursor: pointer;">Mettre à jour</button>
        <a href="{{ route('admin.filtering-rules.index') }}" style="padding: 0.625rem 1.25rem; background-color: #6b7280; color: white; border: none; border-radius: 4px; font-weight: 500; text-decoration: none; display: inline-block;">Annuler</a>
    </div>
</form>


@endsection

