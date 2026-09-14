<?php

namespace App\Livewire;

use App\Models\Learner;
use Livewire\Component;

class LanguageSwitcher extends Component
{
    public function setLocale(string $locale): void
    {
        if (! in_array($locale, ['fr', 'wo'], true)) {
            return;
        }

        session(['locale' => $locale]);
        app()->setLocale($locale);

        if ($id = session('learner_id')) {
            Learner::query()->whereKey($id)->update(['langue_preferee' => $locale]);
        }

        $this->js('window.location.reload()');
    }

    public function render()
    {
        return view('livewire.language-switcher');
    }
}
