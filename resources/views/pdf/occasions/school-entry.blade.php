<x-table>
    <x-slot name="title">
        {{ $title ?? '' }}
    </x-slot>

    <x-slot name="thead">
        <x-th class=" text-center">
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
            {{ __('academic_level') }}
        </x-th>

        <x-th>
            {{ __('filters.gender') }}
        </x-th>

        <x-th>
            {{ __('age') }}
        </x-th>

        <x-th>
            {{ __('the_zone') }}
        </x-th>

        <x-th>
            {{ __('validation.attributes.address') }}
        </x-th>
    </x-slot>

    <x-slot name="tbody">
        @foreach ($sponsorships as $sponsorship)
            <tr>
                <x-td class="text-center ">
                    {{ $loop->iteration }}
                </x-td>

                <x-td class="text-center ">
                    {{ $sponsorship->orphan->sponsor->getName() }}
                </x-td>

                <x-td class="text-center ">
                    {{ $sponsorship->orphan->sponsor->formattedPhoneNumber() }}
                </x-td>

                <x-td class="text-center ">
                    {{ $sponsorship->orphan->getName() }}
                </x-td>

                <x-td class="text-center ">
                    {{ $sponsorship->orphan->lastAcademicYearAchievement?->academicLevel?->level }}
                </x-td>

                <x-td class="text-center ">
                    {{ __($sponsorship->orphan->gender) }}
                </x-td>

                <x-td class="text-center ">
                    {{ trans_choice('age_years', $sponsorship->orphan->birth_date->age) }}
                </x-td>

                <x-td class="text-center ">
                    {{ $sponsorship->orphan->family->zone->name }}
                </x-td>

                <x-td>
                    {{ $sponsorship->orphan->family->address }}
                </x-td>
            </tr>
        @endforeach
    </x-slot>
</x-table>
