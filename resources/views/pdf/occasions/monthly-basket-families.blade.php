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
    </x-slot>

    <x-slot name="tbody">
        @foreach ($sponsorships as $sponsorship)
            <tr>
                <x-td class="text-center">
                    {{ $loop->iteration }}
                </x-td>

                <x-td>
                    {{ $sponsorship->family->sponsor->getName() }}
                </x-td>

                <x-td class="text-center">
                    {{ $sponsorship->family->sponsor->formattedPhoneNumber() }}
                </x-td>

                <x-td class="truncate max-w-28">
                    {{ $sponsorship->family->address  ?? '————' }}
                </x-td>

                <x-td class="text-center">
                    {{ $sponsorship->orphans_count }}
                </x-td>

                <x-td class="text-center">
                    {{ formatCurrency($sponsorship->family->total_income) }}
                </x-td>

                <x-td class="text-center">
                    {{ formatCurrency($sponsorship->family->income_rate) }}
                </x-td>

                <x-td class="max-w-28 truncate text-center">
                    {{ $sponsorship->family->branch?->name ?? '————' }}
                </x-td>

                <x-td class="text-center">
                    {{ $sponsorship->family->zone?->name ?? '————' }}
                </x-td>
            </tr>
        @endforeach
    </x-slot>
</x-table>
