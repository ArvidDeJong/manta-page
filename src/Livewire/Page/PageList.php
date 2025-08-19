<?php

namespace Darvis\MantaPage\Livewire\Page;

use Darvis\MantaPage\Models\Page;
use Livewire\Component;

use Manta\FluxCMS\Traits\SortableTrait;
use Manta\FluxCMS\Traits\MantaTrait;
use Manta\FluxCMS\Traits\WithSortingTrait;
use Livewire\WithPagination;
use Darvis\MantaPage\Traits\PageTrait;
use Livewire\Attributes\Layout;

#[Layout('manta-cms::layouts.app')]
class PageList extends Component
{
    use PageTrait;
    use WithPagination;
    use SortableTrait;
    use MantaTrait;
    use WithSortingTrait;

    public function mount()
    {

        $this->getBreadcrumb();
        $this->sortBy = 'homepageSort';
    }

    public function render()
    {

        $this->trashed = count(Page::whereNull('pid')->onlyTrashed()->get());

        $obj = Page::whereNull('pid');
        if ($this->tablistShow == 'trashed') {
            $obj->onlyTrashed();
        }

        $obj->where('fullpage', '=', 1);

        $obj = $this->applySorting($obj);
        $obj = $this->applySearch($obj);
        $items = $obj->paginate(50);
        return view('manta-page::livewire.page.page-list', ['items' => $items])->layoutData(['title' => $this->config['module_name']['multiple']]);
    }
}
