<?php

namespace Darvis\MantaPage\Livewire\Page;

use Flux\Flux;
use Livewire\Component;
use Darvis\MantaPage\Models\Page;
use Manta\FluxCMS\Traits\MantaTrait;
use Darvis\MantaPage\Traits\PageTrait;
use Livewire\Attributes\Layout;

#[Layout('manta-cms::layouts.app')]
class PageUpdate extends Component
{
    use MantaTrait;
    use PageTrait;

    public function mount(Page $page)
    {
        $this->item = $page;
        $this->itemOrg = translate($page, 'nl')['org'];
        $this->id = $page->id;

        $this->fill(
            $page->only(
                'company_id',
                'pid',
                'locale',
                'description',
                'title',
                'title_2',
                'title_3',
                'title_4',
                'slug',
                'seo_title',
                'seo_description',
                'excerpt',
                'content',
                'template',
                'homepage',
                'homepageSort',
                'locked',
                'fullpage',
                'link',
                'tags',
                'route',
                'route_title',
                'option_1',
                'option_2',
                'option_3',
                'option_4',
            ),
        );
        $this->getLocaleInfo();
        $this->getTablist();
        $this->getBreadcrumb('update');
    }

    public function render()
    {
        return view('manta-cms::livewire.default.manta-default-update')->layoutData(['title' => $this->config['module_name']['single'] . ' aanpassen']);
    }

    public function save()
    {
        $this->validate();

        $row = $this->only(
            'company_id',
            'pid',
            'locale',
            'description',
            'title',
            'title_2',
            'title_3',
            'title_4',
            'slug',
            'seo_title',
            'seo_description',
            'excerpt',
            'content',
            'template',
            'homepage',
            'homepageSort',
            'locked',
            'fullpage',
            'link',
            'tags',
            'route',
            'route_title',
            'option_1',
            'option_2',
            'option_3',
            'option_4',
        );
        $row['updated_by'] = auth('staff')->user()->name;
        Page::where('id', $this->id)->update($row);


        Flux::toast('Opgeslagen', duration: 1000, variant: 'success');
    }
}
