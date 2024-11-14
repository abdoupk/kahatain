<x-table>
    <x-slot name="title">
        {{ $title ?? '' }}
    </x-slot>

    <x-slot name="thead">
        <x-th class="py-0.5">
            <span> #</span>
        </x-th>

        <x-th class="py-0.5">
            {{ __('the_sponsor') }}
        </x-th>

        <x-th class="py-0.5">
            {{ __('sponsor_phone_number') }}
        </x-th>

        <x-th class="py-0.5">
            {{ __('the_orphan') }}
        </x-th>

        <x-th class="py-0.5">
            {{ __('filters.gender') }}
        </x-th>

        <x-th class="py-0.5">
            {{ __('validation.attributes.age') }}
        </x-th>

        <x-th class="py-0.5">
            {{ __('shoes_size') }}
        </x-th>

        <x-th class="py-0.5">
            {{ __('pants_size') }}
        </x-th>

        <x-th class="py-0.5">
            {{ __('shirt_size') }}
        </x-th>

        <x-th class=" py-0.5  text-center">
            {{ __('the_branch') }}
        </x-th>

        <x-th class="truncate  py-0.5  text-center">
            {{ __('the_zone') }}
        </x-th>
    </x-slot>

    <x-slot name="tbody">
        @foreach ($orphans as $orphan)
            <tr>
                <x-td class="py-0.5 text-center">
                    {{ $loop->iteration }}
                </x-td>

                <x-td class="py-0.5">
                    {{ $orphan->sponsor->getName() }}
                </x-td>

                <x-td class="py-0.5  text-center">
                    {{ $orphan->sponsor->formattedPhoneNumber() }}
                </x-td>

                <x-td class="py-0.5  text-center">
                    {{ $orphan->getName() }}
                </x-td>

                <x-td class="py-0.5  text-center">
                    {{ __($orphan->gender) }}
                </x-td>

                <x-td class="py-0.5  text-center">
                    {{ trans_choice('age_years', $orphan->birth_date->age) }}
                </x-td>

                <x-td class="py-0.5  text-center">
                    {{ $orphan->shoesSize?->label }}
                </x-td>

                <x-td class="py-0.5  text-center">
                    {{ $orphan->pantsSize?->label }}
                </x-td>

                <x-td class="py-0.5  text-center">
                    {{ $orphan->shirtSize?->label }}
                </x-td>

                <x-td class="py-0.5  truncate max-w-28 text-center">
                    {{ $orphan->family->branch->name }}
                </x-td>

                <x-td class="py-0.5  text-center">
                    {{ $orphan->family->zone->name }}
                </x-td>
            </tr>
        @endforeach
    </x-slot>
</x-table>
