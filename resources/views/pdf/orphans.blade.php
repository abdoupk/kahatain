<x-table>
    <x-slot name="title">
        {{ $title ?? '' }}
    </x-slot>

    <x-slot name="thead">
        <x-th class="">
            <span> #</span>
        </x-th>

        <x-th class="">
            {{ __('the_orphan') }}
        </x-th>

        <x-th class="">
            {{ __('health_status') }}
        </x-th>

        <x-th class="">
            {{ __('family_status') }}
        </x-th>

        <x-th class="">
            {{ __('academic_level') }}
        </x-th>

        <x-th class="">
            {{ __('shoes_size') }}
        </x-th>

        <x-th class="">
            {{ __('pants_size') }}
        </x-th>

        <x-th class="">
            {{ __('shirt_size') }}
        </x-th>

        <x-th class="">
            {{ __('filters.gender') }}
        </x-th>

        <x-th class="">
            {{ __('income') }}
        </x-th>

        <x-th class="">
            {{ __('filters.birth_date') }}
        </x-th>
    </x-slot>

    <x-slot name="tbody">
        @foreach ($orphans as $orphan)
            <tr>
                <x-td class="text-center">
                    {{ $loop->iteration }}
                </x-td>

                <x-td class="text-center">
                    {{ $orphan->getName() }}
                </x-td>

                <x-td class="text-center">
                    {{ $orphan->health_status ?? '————' }}
                </x-td>

                <x-td class="text-center">
                    {{ $orphan->family_status ? __('family_statuses.' . $orphan->family_status) : '————' }}
                </x-td>

                <x-td class="text-center">
                    {{ $orphan->academicLevel?->level ?? '————' }}
                </x-td>

                <x-td class="text-center">
                    {{ $orphan->shoesSize?->label ?? '————' }}
                </x-td>

                <x-td class="text-center">
                    {{ $orphan->pantsSize?->label ?? '————' }}
                </x-td>

                <x-td class="text-center">
                    {{ $orphan->shirtSize?->label ?? '————' }}
                </x-td>

                <x-td class="text-center">
                    {{ __($orphan->gender) }}
                </x-td>

                <x-td class="text-center">
                    {{ formatCurrency($orphan->income) }}
                </x-td>

                <x-td class="text-center">
                    {{ $orphan->birth_date->format('Y/m/d') }}
                </x-td>
            </tr>
        @endforeach
    </x-slot>
</x-table>
