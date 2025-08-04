<flux:main>
    <x-manta.breadcrumb :$breadcrumb />
    <div class="mt-4 flex">
        <div class="flex-grow">
            <x-manta.buttons.large type="add" :href="route($this->route_name . '.create')" />
        </div>
        <div class="w-1/5">
            <x-manta.input.search />
        </div>
    </div>
    <x-manta.tables.tabs :$tablistShow :$trashed />
    <flux:table :paginate="$items">
        <flux:table.columns>
            <flux:table.column>ID</flux:table.column>
            <flux:table.column sortable :sorted="$sortBy === 'description'" :direction="$sortDirection"
                wire:click="dosort('description')">
                Beschrijving</flux:table.column>
            <flux:table.column sortable :sorted="$sortBy === 'title'" :direction="$sortDirection"
                wire:click="dosort('title')">
                Titel</flux:table.column>
            @if (isset($fields['option_1']['active']) && $fields['option_1']['active'])
                <flux:table.column sortable :sorted="$sortBy === 'option_1'" :direction="$sortDirection"
                    wire:click="dosort('option_1')">
                    Policy</flux:table.column>
            @endif
            <flux:table.column>Uploads</flux:table.column>
            @if ($fields['homepage']['active'])
                <flux:table.column sortable :sorted="$sortBy === 'homepage'" :direction="$sortDirection"
                    wire:click="dosort('homepage')">
                    Homepage</flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'homepageSort'" :direction="$sortDirection"
                    wire:click="dosort('homepageSort')">
                    Sorteer</flux:table.column>
            @endif
            <flux:table.column sortable :sorted="$sortBy === 'slug'" :direction="$sortDirection"
                wire:click="dosort('slug')">
                Slug</flux:table.column>
        </flux:table.columns>
        <flux:table.rows>
            @foreach ($items as $item)
                <flux:table.row data-id="{{ $item->id }}">
                    <flux:table.cell>
                        <flux:avatar size="xs" src="{{ $item->customer_avatar }}" />
                    </flux:table.cell>
                    <flux:table.cell>
                        {{ $item->description }}
                    </flux:table.cell>
                    <flux:table.cell>
                        {{ $item->title }}
                    </flux:table.cell>
                    @if (isset($fields['option_1']['active']) && $fields['option_1']['active'])
                        <flux:table.cell>
                            {!! $item->option_1 ? '<i class="fa-solid fa-check"></i>' : null !!}
                        </flux:table.cell>
                    @endif
                    <flux:table.cell variant="strong">
                        {{ count($item->uploads) > 0 ? count($item->uploads) : null }}
                    </flux:table.cell>
                    @if ($fields['homepage']['active'])
                        <flux:table.cell>
                            {!! $item->homepage ? '<i class="fa-solid fa-check"></i>' : null !!}
                        </flux:table.cell>
                        <flux:table.cell>
                            {{ $item->homepageSort }}
                        </flux:table.cell>
                    @endif
                    <flux:table.cell>
                        @if ($item->slug && Route::has('website.page'))
                            <a href="{{ route('website.page', ['slug' => $item->slug]) }}" target="_blank"
                                class="text-blue-500 hover:text-blue-800"> {{ $item->slug }} </a>
                        @else
                            {{ $item->slug }}
                        @endif
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:button size="sm" href="{{ route($this->route_name . '.read', $item) }}"
                            icon="eye" />
                        <x-manta.tables.delete-modal :item="$item" />
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
</flux:main>
