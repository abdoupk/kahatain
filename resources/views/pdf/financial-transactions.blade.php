<x-table>
    <x-slot name="title">
        {{ $title ?? '' }}
    </x-slot>

    <x-slot name="thead">
        <x-th>
            <span> #</span>
        </x-th>

        <x-th>
            {{ __('receiving_member') }}
        </x-th>

        <x-th>
            {{ __('the_amount') }}
        </x-th>

        <x-th>
            {{ __('validation.attributes.specification') }}
        </x-th>

        <x-th>
            {{ __('the_type') }}
        </x-th>

        <x-th>
            {{ __('the date') }}
        </x-th>
    </x-slot>

    <x-slot name="tbody">
        @foreach ($transactions as $transaction)
            <tr>
                <x-td class="text-center">
                    {{ $loop->iteration }}
                </x-td>

                <x-td class="text-center">
                    {{ $transaction->receiver?->getName() ?? '————' }}
                </x-td>

                <x-td class="text-center">
                    {{ formatCurrency(abs($transaction->amount)) }}
                </x-td>

                <x-td class="text-center">
                    {{ __($transaction->specification) }}
                </x-td>

                <x-td class="text-center">
                    {{ $transaction->amount > 0 ? __('income') : __('expense') }}
                </x-td>

                <x-td class="text-center">
                    {{ $transaction->date->translatedFormat('j F Y') }}
                </x-td>
            </tr>
        @endforeach

        <tr>
            <x-td class="text-center font-semibold" colspan="2">
                {{ __('the_total_amount') }}
            </x-td>

            <x-td class="text-center">
                {{ formatCurrency($transactions->sum('amount')) }}
            </x-td>
        </tr>
    </x-slot>
</x-table>
