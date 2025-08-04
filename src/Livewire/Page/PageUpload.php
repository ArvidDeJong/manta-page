<?php

namespace Darvis\MantaPage\Livewire\Page;

use Livewire\Component;
use Darvis\MantaPage\Models\Page;
use Manta\FluxCMS\Traits\MantaTrait;
use Darvis\MantaPage\Traits\PageTrait;
use Livewire\Attributes\Layout;

#[Layout('manta-cms::layouts.app')]
class PageUpload extends Component
{
    use MantaTrait;
    use PageTrait;

    public function mount(Page $page)
    {
        $this->item = $page;
        $this->itemOrg = $page;
        $this->id = $page->id;
        $this->locale = $page->locale;

        $this->getLocaleInfo();
        $this->getTablist();
        $this->getBreadcrumb('upload');
    }

    public function render()
    {
        return view('manta-cms::livewire.default.manta-default-upload')->layoutData(['title' => $this->config['module_name']['single'] . ' bestanden']);
    }
}
