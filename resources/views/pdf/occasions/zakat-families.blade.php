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
            {{ __('aggregate_zakat_benefit') }}
        </x-th>

        <x-th>
            {{ __('incomes.label.total_income') }}
        </x-th>

        <x-th>
            {{ __('income_rate') }}
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

                <x-td class="truncate max-w-28">
                    {{ $family->address  ?? '————' }}
                </x-td>

                <x-td class="text-center">
                    {{ $family->orphans_count }}
                </x-td>

                <x-td class="text-center">
                    {{ formatCurrency($family->aggregate_zakat_benefit) }}
                </x-td>

                <x-td class="text-center">
                    {{ formatCurrency($family->total_income) }}
                </x-td>

                <x-td class="text-center">
                    {{ formatCurrency($family->income_rate) }}
                </x-td>
            </tr>
        @endforeach
    </x-slot>
</x-table>
