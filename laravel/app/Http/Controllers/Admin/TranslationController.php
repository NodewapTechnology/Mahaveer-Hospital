<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\I18n;
use App\Models\UiTranslation;
use Illuminate\Http\Request;

class TranslationController extends AdminBaseController
{
    public function index(Request $request)
    {
        $q = $request->get('q');
        $items = UiTranslation::query()
            ->when($q, fn($x) => $x->where('key', 'like', "%$q%")->orWhere('en_value', 'like', "%$q%")->orWhere('hi_value', 'like', "%$q%"))
            ->orderBy('group')->orderBy('key')->paginate(30)->withQueryString();
        return view('admin.translations.index', compact('items', 'q'));
    }

    public function create()
    {
        return view('admin.translations.form', ['item' => new UiTranslation()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        UiTranslation::create($data);
        I18n::flushCache();
        return redirect()->route('admin.translations.index')->with('success', 'Translation added.');
    }

    public function edit(UiTranslation $translation)
    {
        return view('admin.translations.form', ['item' => $translation]);
    }

    public function update(Request $request, UiTranslation $translation)
    {
        $data = $this->validated($request, $translation->id);
        $translation->update($data);
        I18n::flushCache();
        return redirect()->route('admin.translations.index')->with('success', 'Translation updated.');
    }

    public function destroy(UiTranslation $translation)
    {
        $translation->delete();
        I18n::flushCache();
        return redirect()->route('admin.translations.index')->with('success', 'Translation deleted.');
    }

    public function seedDefaults()
    {
        $defaults = I18n::defaults();
        foreach ($defaults['en'] as $key => $en) {
            UiTranslation::updateOrCreate(
                ['key' => $key],
                [
                    'en_value' => $en,
                    'hi_value' => $defaults['hi'][$key] ?? null,
                    'group' => explode('.', $key, 2)[0] ?? 'general',
                ]
            );
        }
        I18n::flushCache();
        return redirect()->route('admin.translations.index')->with('success', 'Default translations imported.');
    }

    private function validated(Request $r, ?int $id = null): array
    {
        return $r->validate([
            'key' => 'required|string|max:120|unique:ui_translations,key' . ($id ? ",$id" : ''),
            'en_value' => 'required|string|max:500',
            'hi_value' => 'nullable|string|max:500',
            'group' => 'nullable|string|max:60',
            'note' => 'nullable|string|max:500',
        ]);
    }
}
