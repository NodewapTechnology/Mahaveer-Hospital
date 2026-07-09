@extends('admin.layout')
@section('title', 'Language Translations')
@section('content')
<div class="card">
    <div class="card-header">
        <div>
            <h2>UI Translations <span class="text-muted" style="font-size:.85rem;font-weight:500;">({{ $items->total() }})</span></h2>
            <p class="text-muted" style="margin:.15rem 0 0;font-size:.86rem;">Manage English &amp; Hindi text used across the site (nav, buttons, labels, messages).</p>
        </div>
        <div style="display:flex;gap:.5rem;">
            <form method="POST" action="{{ route('admin.translations.seed') }}" data-confirm="Import default translations? Existing keys will be kept.">
                @csrf
                <button type="submit" class="btn-adm btn-outline" data-testid="btn-seed-defaults"><i class="fas fa-download"></i> Import Defaults</button>
            </form>
            <a href="{{ route('admin.translations.create') }}" class="btn-adm btn-primary" data-testid="btn-add-translation"><i class="fas fa-plus"></i> Add Translation</a>
        </div>
    </div>

    <form method="GET" style="padding:0 1.25rem 1rem;">
        <input type="text" name="q" value="{{ $q }}" placeholder="Search by key or value..." class="form-control-adm" style="max-width:340px;" data-testid="translations-search">
    </form>

    <div class="table-wrap">
        <table class="table">
            <thead>
                <tr>
                    <th style="width:120px;">Group</th>
                    <th>Key</th>
                    <th>English</th>
                    <th>Hindi (हिन्दी)</th>
                    <th style="width:100px;"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $t)
                    <tr data-testid="translation-row-{{ $t->id }}">
                        <td><span class="badge badge-muted">{{ $t->group ?? 'general' }}</span></td>
                        <td><code style="font-size:.82rem;color:var(--a-primary);">{{ $t->key }}</code></td>
                        <td>{{ $t->en_value }}</td>
                        <td style="font-family:'Noto Sans Devanagari','Manrope',sans-serif;">{{ $t->hi_value ?: '—' }}</td>
                        <td class="table-actions">
                            <a href="{{ route('admin.translations.edit', $t) }}" class="btn-adm btn-outline btn-sm" data-testid="translation-edit-{{ $t->id }}"><i class="fas fa-pen"></i></a>
                            <form method="POST" action="{{ route('admin.translations.destroy', $t) }}" class="d-inline" data-confirm="Delete this translation?">
                                @csrf @method('DELETE')
                                <button class="btn-adm btn-danger btn-sm" data-testid="translation-delete-{{ $t->id }}"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" style="text-align:center;padding:2.5rem;color:var(--a-muted);">
                        No translations yet. Click <strong>Import Defaults</strong> to seed English/Hindi labels used across the site.
                    </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="padding:1rem 1.25rem;">
        {{ $items->links() }}
    </div>
</div>
@endsection
