@extends('admin.layout')

@section('title', 'Gestion des utilisateurs')

@section('content')
<div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
    <h1 style="font-size: 1.5rem; font-weight: 600; color: #1a1a1a; margin: 0; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Gestion des utilisateurs</h1>
    <a href="{{ route('admin.users.create') }}" class="btn" style="background-color: #00C853; color: rgb(255, 255, 255); border: none; padding: 0.625rem 1.25rem; font-weight: 500; font-size: 0.875rem; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; border-radius: 4px; text-decoration: none; display: inline-flex; align-items: center; justify-content: center;" onmouseover="this.style.backgroundColor='#00B04A';" onmouseout="this.style.backgroundColor='#00C853';">
        + Nouvel utilisateur
    </a>
</div>

<div style="overflow-x: auto; background-color: #ffffff; border: 1px solid #d1d5db; border-radius: 4px;">
    <table style="width: 100%; border-collapse: collapse; margin: 0;">
        <thead>
            <tr style="background-color: #f9fafb; border-bottom: 2px solid #d1d5db;">
                <th style="padding: 0.75rem 1rem; text-align: left; font-size: 0.8125rem; font-weight: 600; color: #374151; border-right: 1px solid #e5e7eb; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Nom</th>
                <th style="padding: 0.75rem 1rem; text-align: left; font-size: 0.8125rem; font-weight: 600; color: #374151; border-right: 1px solid #e5e7eb; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Email</th>
                <th style="padding: 0.75rem 1rem; text-align: left; font-size: 0.8125rem; font-weight: 600; color: #374151; border-right: 1px solid #e5e7eb; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Rôle</th>
                <th style="padding: 0.75rem 1rem; text-align: right; font-size: 0.8125rem; font-weight: 600; color: #374151; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr style="border-bottom: 1px solid #e5e7eb;">
                <td style="padding: 0.75rem 1rem; border-right: 1px solid #e5e7eb; font-size: 0.875rem; color: #1a1a1a; font-weight: 500; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">{{ $user->name }}</td>
                <td style="padding: 0.75rem 1rem; border-right: 1px solid #e5e7eb; font-size: 0.875rem; color: #374151; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">{{ $user->email }}</td>
                <td style="padding: 0.75rem 1rem; border-right: 1px solid #e5e7eb;">
                    <span style="display: inline-block; padding: 0.25rem 0.625rem; border-radius: 4px; font-size: 0.75rem; font-weight: 500; background-color: {{ $user->role ? 'rgba(0, 200, 83, 0.1)' : '#f3f4f6' }}; color: {{ $user->role ? '#00C853' : '#6b7280' }}; border: 1px solid {{ $user->role ? 'rgba(0, 200, 83, 0.2)' : '#e5e7eb' }}; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                        {{ $user->role->display_name ?? 'Aucun rôle' }}
                    </span>
                </td>
                <td style="padding: 0.75rem 1rem; text-align: right;">
                    <div style="display: flex; align-items: center; justify-content: flex-end; gap: 0.375rem;">
                        <a href="{{ route('admin.users.edit', $user) }}" style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; color: #2563eb; text-decoration: none; border-radius: 5px; background-color: transparent; transition: all 0.2s ease; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;" onmouseover="this.style.backgroundColor='#eff6ff'; this.style.color='#1d4ed8';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#2563eb';" title="Modifier">
                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </a>
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display: inline; margin: 0;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; padding: 0; border: none; background-color: transparent; cursor: pointer; color: #dc2626; border-radius: 5px; transition: all 0.2s ease; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;" onmouseover="this.style.backgroundColor='#fef2f2'; this.style.color='#b91c1c';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#dc2626';" title="Supprimer">
                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 6h14"></path>
                                    <path d="M8 6V4a2 2 0 0 1 2-2h0a2 2 0 0 1 2 2v2"></path>
                                    <path d="M5 6v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V6"></path>
                                    <path d="M8 10v6"></path>
                                    <path d="M12 10v6"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align: center; padding: 2rem; color: #9ca3af; font-size: 0.875rem; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Aucun utilisateur trouvé</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($users->hasPages())
<div style="margin-top: 0; padding: 0.75rem 1rem; background-color: #ffffff; border: 1px solid #d1d5db; border-top: none; border-radius: 0 0 4px 4px; display: flex; justify-content: space-between; align-items: center;">
    <div style="font-size: 0.875rem; color: #374151; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
        Lignes {{ $users->firstItem() }} à {{ $users->lastItem() }} sur {{ $users->total() }}
    </div>
    <div>
        {{ $users->links() }}
    </div>
</div>
@endif
@endsection
