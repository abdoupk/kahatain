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
            {{ __('the_orphan') }}
        </x-th>

        <x-th>
            {{ __('filters.gender') }}
        </x-th>

        <x-th>
            {{ __('age') }}
        </x-th>

        <x-th>
            {{ __('baby_milk_type') }}
        </x-th>

        <x-th>
            {{ __('baby_milk_quantity') }}
        </x-th>

        <x-th>
            {{ __('diapers_type') }}
        </x-th>

        <x-th>
            {{ __('diapers_quantity') }}
        </x-th>
    </x-slot>

    <x-slot name="tbody">
        @foreach ($babies as $baby)
            <tr>
                <x-td class="   text-center ">
                    {{ $loop->iteration }}
                </x-td>

                <x-td class="   text-center ">
                    {{ $baby->orphan->sponsor->getName() }}
                </x-td>

                <x-td class="   text-center ">
                    {{ $baby->orphan->sponsor->formattedPhoneNumber() }}
                </x-td>

                <x-td class="   text-center ">
                    {{ $baby->getName() }}
                </x-td>

                <x-td class="   text-center ">
                    {{ __($baby->orphan->gender) }}
                </x-td>

                <x-td class="   text-center ">
                    {{ calculateAge($baby->orphan->birth_date) }}
                </x-td>

                <x-td class="   text-center ">
                    {{ $baby?->babyMilk?->name ?? '————' }}
                </x-td>

                <x-td class="   text-center ">
                    {{ $baby->baby_milk_quantity ?? '————' }}
                </x-td>

                <x-td class="   text-center ">
                    {{ $baby?->diapers?->name ?? '————' }}
                </x-td>

                <x-td class="    text-center">
                    {{ $baby->diapers_quantity ?? '————'}}
                </x-td>
            </tr>
        @endforeach
    </x-slot>
</x-table>
