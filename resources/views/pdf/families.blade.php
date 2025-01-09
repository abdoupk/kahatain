<x-table>
    <x-slot name="title">
        {{ $title ?? '' }}
    </x-slot>

    <x-slot name="thead">
        <x-th>
            <span> #</span>
        </x-th>

        <x-th>
            {{ __('the_sponsor') }}
        </x-th>

        <x-th>
            {{ __('validation.attributes.address') }}
        </x-th>

        <x-th>
            {{ __('orphans_count') }}
        </x-th>

        <x-th>
            {{ __('incomes.label.total_income') }}
        </x-th>

        <x-th>
            {{ __('income_rate') }}
        </x-th>

        <x-th>
            {{ __('the_branch') }}
        </x-th>

        <x-th>
            {{ __('the_zone') }}
        </x-th>

        <x-th>
            {{ __('file_number') }}
        </x-th>

        <x-th>
            {{ __('validation.attributes.starting_sponsorship_date') }}
        </x-th>
    </x-slot>

    <x-slot name="tbody">
        @foreach ($families as $family)
            <tr>
                <x-td class="text-center">
                    {{ $loop->iteration }}
                </x-td>

                <x-td>
                    {{ $family->sponsor->getName() }}
                </x-td>

                <x-td>
                    {{ $family->address }}
                </x-td>

                <x-td class="text-center">
                    {{ $family->orphans_count }}
                </x-td>

                <x-td class="whitespace-nowrap text-center">
                    {{ formatCurrency($family->total_income) }}
                </x-td>

                <x-td class="whitespace-nowrap text-center">
                    {{ $family->income_rate }}
                </x-td>

                <x-td>
                    {{ $family->branch?->name }}
                </x-td>

                <x-td class="whitespace-nowrap">
                    {{ $family->zone?->name }}
                </x-td>

                <x-td class="text-center">
                    {{ $family->file_number }}
                </x-td>

                <x-td>
                    {{ $family->start_date->format('Y/m/d') }}
                </x-td>
            </tr>
        @endforeach
    </x-slot>
</x-table>
