@extends('admin.layout')

@section('title', 'Configuration des appels d\'offres')

@section('content')
<div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
    <h1 style="font-size: 1.5rem; font-weight: 600; color: #1a1a1a; margin: 0; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Configuration des appels d'offres</h1>
    <div style="display: flex; gap: 0.75rem; align-items: center;">
        <form action="{{ route('admin.appel-offre-configs.scrape') }}" method="POST" style="display: inline; margin: 0;" onsubmit="return confirm('Voulez-vous lancer le scraping de tous les sites configurés ? Cela peut prendre quelques minutes.');">
            @csrf
            <button type="submit" style="background-color: #2563eb; color: rgb(255, 255, 255); border: none; padding: 0.625rem 1.25rem; font-weight: 500; font-size: 0.875rem; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; border-radius: 4px; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem;" onmouseover="this.style.backgroundColor='#1d4ed8';" onmouseout="this.style.backgroundColor='#2563eb';">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21.5 2v6h-6M2.5 22v-6h6M2 11.5a10 10 0 0 1 18.8-4.3M22 12.5a10 10 0 0 1-18.8 4.2"></path>
                </svg>
                Lancer le scraping
            </button>
        </form>
        <a href="{{ route('admin.appel-offre-configs.create') }}" class="btn" style="background-color: #00C853; color: rgb(255, 255, 255); border: none; padding: 0.625rem 1.25rem; font-weight: 500; font-size: 0.875rem; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; border-radius: 4px; text-decoration: none; display: inline-flex; align-items: center; justify-content: center;" onmouseover="this.style.backgroundColor='#00B04A';" onmouseout="this.style.backgroundColor='#00C853';">
            + Nouvelle configuration
        </a>
    </div>
</div>

<div style="overflow-x: auto; background-color: #ffffff; border: 1px solid #d1d5db; border-radius: 4px;">
    <table style="width: 100%; border-collapse: collapse; margin: 0;">
        <thead>
            <tr style="background-color: #f9fafb; border-bottom: 2px solid #d1d5db;">
                <th style="padding: 0.75rem 1rem; text-align: left; font-size: 0.8125rem; font-weight: 600; color: #374151; border-right: 1px solid #e5e7eb; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Source (PTF)</th>
                <th style="padding: 0.75rem 1rem; text-align: left; font-size: 0.8125rem; font-weight: 600; color: #374151; border-right: 1px solid #e5e7eb; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Type de Marché</th>
                <th style="padding: 0.75rem 1rem; text-align: left; font-size: 0.8125rem; font-weight: 600; color: #374151; border-right: 1px solid #e5e7eb; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Pôle d'Activité</th>
                <th style="padding: 0.75rem 1rem; text-align: left; font-size: 0.8125rem; font-weight: 600; color: #374151; border-right: 1px solid #e5e7eb; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Zone Géographique</th>
                <th style="padding: 0.75rem 1rem; text-align: left; font-size: 0.8125rem; font-weight: 600; color: #374151; border-right: 1px solid #e5e7eb; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Site officiel</th>
                <th style="padding: 0.75rem 1rem; text-align: right; font-size: 0.8125rem; font-weight: 600; color: #374151; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($configs as $config)
            <tr style="border-bottom: 1px solid #e5e7eb;">
                <td style="padding: 0.75rem 1rem; border-right: 1px solid #e5e7eb; font-size: 0.875rem; color: #1a1a1a; font-weight: 500; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">{{ $config->source_ptf }}</td>
                <td style="padding: 0.75rem 1rem; border-right: 1px solid #e5e7eb; font-size: 0.875rem; color: #374151; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">{{ $config->typeMarche->nom ?? '—' }}</td>
                <td style="padding: 0.75rem 1rem; border-right: 1px solid #e5e7eb; font-size: 0.875rem; color: #374151; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">{{ $config->poleActivite->nom ?? '—' }}</td>
                <td style="padding: 0.75rem 1rem; border-right: 1px solid #e5e7eb; font-size: 0.875rem; color: #374151; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">{{ $config->zone_geographique ?? '—' }}</td>
                <td style="padding: 0.75rem 1rem; border-right: 1px solid #e5e7eb; font-size: 0.875rem; color: #374151; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                    @if($config->site_officiel)
                        <a href="{{ $config->site_officiel }}" target="_blank" rel="noopener noreferrer" style="color: #2563eb; text-decoration: underline;">{{ \Illuminate\Support\Str::limit($config->site_officiel, 40) }}</a>
                    @else
                        <span style="color: #9ca3af;">—</span>
                    @endif
                </td>
                <td style="padding: 0.75rem 1rem; text-align: right;">
                    <div style="display: flex; align-items: center; justify-content: flex-end; gap: 0.375rem;">
                        <a href="{{ route('admin.appel-offre-configs.edit', $config) }}" style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; color: #2563eb; text-decoration: none; border-radius: 5px; background-color: transparent; transition: all 0.2s ease; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;" onmouseover="this.style.backgroundColor='#eff6ff'; this.style.color='#1d4ed8';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#2563eb';" title="Modifier">
                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </a>
                        <form action="{{ route('admin.appel-offre-configs.destroy', $config) }}" method="POST" style="display: inline; margin: 0;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette configuration ?');">
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
                <td colspan="6" style="text-align: center; padding: 2rem; color: #9ca3af; font-size: 0.875rem; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Aucune configuration trouvée</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($configs->hasPages())
<div style="margin-top: 0; padding: 0.75rem 1rem; background-color: #ffffff; border: 1px solid #d1d5db; border-top: none; border-radius: 0 0 4px 4px; display: flex; justify-content: space-between; align-items: center;">
    <div style="font-size: 0.875rem; color: #374151; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
        Lignes {{ $configs->firstItem() }} à {{ $configs->lastItem() }} sur {{ $configs->total() }}
    </div>
    <div>
        {{ $configs->links() }}
    </div>
</div>
@endif
@endsection

