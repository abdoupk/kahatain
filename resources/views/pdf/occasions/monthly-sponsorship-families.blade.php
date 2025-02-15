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
            {{ __('sponsor_phone_number') }}
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
            {{ __('filters.amount_from_benefactor') }}
        </x-th>

        <x-th>
            {{ __('filters.basket_from_benefactor') }}
        </x-th>

        <x-th>
            {{ __('filters.monthly_sponsorship') }}
        </x-th>

        <x-th>
            {{ __('the_receiving') }}
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

                <x-td class="text-center">
                    {{ $family->sponsor->formattedPhoneNumber() }}
                </x-td>

                <x-td class="text-center">
                    {{ formatCurrency($family->income_rate) }}
                </x-td>

                <x-td class="max-w-28 truncate text-center">
                    {{ $family->branch?->name ?? '————' }}
                </x-td>

                <x-td class="text-center">
                    {{ $family->zone?->name ?? '————' }}
                </x-td>

                <x-td class="text-center">
                    {{ formatCurrency($family->aid->where('sponsorship_type', '!=', 'monthly_basket')->sum('amount')) }}
                </x-td>

                <x-td class="text-center">
                    {{ formatCurrency($family->aid->where('sponsorship_type', '=', 'monthly_basket')->sum('amount')) }}
                </x-td>

                <x-td class="text-center">
                    {{ formatCurrency($family->amount_from_association) }}
                </x-td>

                <x-td class="w-12"></x-td>
            </tr>
        @endforeach
    </x-slot>
</x-table>
