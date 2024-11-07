<x-table>
    <x-slot name="title">
        {{ $title ?? '' }}
    </x-slot>

    <x-slot name="thead">
        <x-th class="text-center">
            <span> #</span>
        </x-th>

        <x-th>
            {{ __('the_sponsor') }}
        </x-th>

        <x-th>
            {{ __('phone_number') }}
        </x-th>

        <x-th>
            {{ __('filters.sponsor_type') }}
        </x-th>

        <x-th>
            {{ __('filters.gender') }}
        </x-th>

        <x-th>
            {{ __('health_status') }}
        </x-th>

        <x-th>
            {{ __('academic_level') }}
        </x-th>

        <x-th>
            {{ __('filters.birth_date') }}
        </x-th>

        <x-th>
            {{ __('orphans_count') }}
        </x-th>

        <x-th>
            {{ __('diploma') }}
        </x-th>

        <x-th>
            ccp
        </x-th>

        <x-th>
            {{ __('income') }}
        </x-th>
    </x-slot>

    <x-slot name="tbody">
        @foreach ($sponsors as $sponsor)
            <tr>
                <x-td class=" text-center">
                    {{ $loop->iteration }}
                </x-td>

                <x-td class=" text-center">
                    {{ $sponsor->getName() }}
                </x-td>

                <x-td>
                    {{ $sponsor->formattedPhoneNumber() }}
                </x-td>

                <x-td class=" text-center">
                    {{ __('sponsor_types.' . $sponsor->sponsor_type) }}
                </x-td>

                <x-td class=" text-center">
                    {{ __($sponsor->gender) }}
                </x-td>

                <x-td class=" text-center">
                    {{ $sponsor->health_status }}
                </x-td>

                <x-td class=" text-center">
                    {{ $sponsor->academicLevel?->level }}
                </x-td>

                <x-td class=" text-center">
                    {{ $sponsor->birth_date->format('Y/m/d') }}
                </x-td>

                <x-td class=" text-center">
                    {{ $sponsor->orphans_count }}
                </x-td>

                <x-td class=" text-center">
                    {{ $sponsor->diploma }}
                </x-td>

                <x-td class=" text-center">
                    {{ $sponsor->ccp }}
                </x-td>

                <x-td class=" text-center">
                    {{ formatCurrency($sponsor->incomes->total_income ?? 0) }}
                </x-td>
            </tr>
        @endforeach
    </x-slot>
</x-table>
