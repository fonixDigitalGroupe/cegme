@extends('admin.layout')

@section('title', 'Modifier la source de filtrage')

@section('content')
<div style="max-width: 600px; margin: 0 auto;">
    <div style="margin-bottom: 1.5rem; text-align: center;">
        <h1 style="font-size: 1.5rem; font-weight: 600; color: #1a1a1a; margin: 0;">Modifier la source de filtrage</h1>
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
    @method('PATCH')

    <div style="margin-bottom: 1.5rem; max-width: 500px;">
        <label for="name" style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Nom de la source *</label>
        <input type="text" id="name" name="name" value="{{ old('name', $filteringRule->name) }}" required style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 0.875rem; transition: border-color 0.2s;" onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='#d1d5db'">
    </div>

    <div style="margin-bottom: 2rem; max-width: 500px;">
        <label for="source" style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Source *</label>
        <select id="source" name="source" required style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 0.875rem; background-color: #fff;">
            @foreach($sources as $source)
                <option value="{{ $source }}" {{ old('source', $filteringRule->source) === $source ? 'selected' : '' }}>{{ $source }}</option>
            @endforeach
        </select>
    </div>

    <div style="margin-bottom: 2rem; display: flex; align-items: center; gap: 1rem;">
        <label style="display: flex; align-items: center; cursor: pointer; padding: 0.5rem 0;">
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $filteringRule->is_active) ? 'checked' : '' }} style="margin-right: 0.75rem; width: 18px; height: 18px; accent-color: #10b981;">
            <span style="font-size: 0.875rem; font-weight: 600; color: #374151;">Activer</span>
        </label>
    </div>

    <div style="display: flex; gap: 1rem; border-top: 1px solid #e5e7eb; padding-top: 2rem;">
        <button type="submit" style="padding: 0.75rem 1.75rem; background-color: #00C853; color: white; border: none; border-radius: 6px; font-weight: 600; font-size: 0.875rem; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#00a946'" onmouseout="this.style.backgroundColor='#00C853'">
            Mettre à jour la source
        </button>
        <a href="{{ route('admin.filtering-rules.index') }}" style="padding: 0.75rem 1.75rem; background-color: #6b7280; color: white; border: none; border-radius: 6px; font-weight: 600; font-size: 0.875rem; text-decoration: none; display: inline-block; transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='#4b5563'" onmouseout="this.style.backgroundColor='#6b7280'">
            Annuler
        </a>
    </div>
    </form>
</div>



@endsection

