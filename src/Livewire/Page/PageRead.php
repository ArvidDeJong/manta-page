<?php

namespace Darvis\MantaPage\Livewire\Page;

use Livewire\Component;
use Darvis\MantaPage\Models\Page;
use Manta\FluxCMS\Traits\MantaTrait;
use Illuminate\Http\Request;
use Darvis\MantaPage\Traits\PageTrait;
use Livewire\Attributes\Layout;

#[Layout('manta-cms::layouts.app')]
class PageRead extends Component
{
    use MantaTrait;
    use PageTrait;

    public function mount(Request $request, Page $page)
    {
        $this->item = $page;
        $this->itemOrg = $page;
        $this->locale = $page->locale;
        if ($request->input('locale') && $request->input('locale') != getLocaleManta()) {
            $this->pid = $page->id;
            $this->locale = $request->input('locale');
            $item_translate = Page::where(['pid' => $page->id, 'locale' => $request->input('locale')])->first();
            $this->item = $item_translate;
        }

        if ($page) {
            $this->id = $page->id;
        }

        $this->getLocaleInfo();
        $this->tablistShow = $this->locale;
        $this->getTablist();
        $this->getBreadcrumb('read');
    }

    public function render()
    {
        return view('manta-cms::livewire.default.manta-default-read')->layoutData(['title' => $this->config['module_name']['single'] . ' bekijken']);
    }
}
