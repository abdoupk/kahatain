<x-table>
    <x-slot name="title">
        {{ $title ?? '' }}
    </x-slot>

    <x-slot name="thead">
        <x-th class="text-center">
            <span> #</span>
        </x-th>

        <x-th class="text-center">
            <span> {{__('item_name')}}</span>
        </x-th>

        <x-th class="text-center">
            <span> {{__('validation.attributes.qty')}}</span>
        </x-th>

        <x-th class="text-center">
            <span> {{__('validation.attributes.qty_for_family')}}</span>
        </x-th>
    </x-slot>

    <x-slot name="tbody">
        @foreach ($ramadan_basket as $item)
            <tr>
                <x-td class="text-center">
                    {{ $loop->iteration }}
                </x-td>

                <x-td class="text-center truncate max-w-36">
                    {{ $item->inventory->name }}
                </x-td>

                <x-td class="text-center">
                    {{ $item->inventory->qty }}
                    ({{ __($item->inventory->unit) }})
                </x-td>

                <x-td class="text-center">
                    {{ $item->qty_for_family }}
                </x-td>
        @endforeach
    </x-slot>
</x-table>
