@extends('admin.layout')
@section('title', 'SEO Settings')
@section('content')
<div class="card">
    <div class="card-header"><h2>SEO Settings <span class="text-muted" style="font-size:.85rem;font-weight:500;">({{ count($items) }})</span></h2></div>
    <div class="table-wrap">
        <table class="table">
            <thead><tr><th>Page</th><th>Title</th><th>Description</th><th></th></tr></thead>
            <tbody>
                @foreach($items as $s)
                    <tr>
                        <td><strong>{{ ucfirst($s->page_key) }}</strong></td>
                        <td>{{ Str::limit($s->title, 60) }}</td>
                        <td class="text-muted" style="max-width:400px;">{{ Str::limit($s->description, 100) }}</td>
                        <td class="table-actions"><a href="{{ route('admin.seo-settings.edit', $s) }}" class="btn-adm btn-outline btn-sm"><i class="fas fa-pen"></i> Edit</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
