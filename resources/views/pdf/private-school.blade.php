@php
    $counter = 0;
@endphp

<x-table>
    <x-slot name="title">
        {{ $title ?? '' }}
    </x-slot>

    <x-slot name="thead">
        <x-th class="text-center">
            <span> #</span>
        </x-th>

        <x-th class="text-center">
            <span> {{__('first_and_last_name')}}</span>
        </x-th>

        <x-th class="text-center">
            <span> {{__('academic_level')}}</span>
        </x-th>

        <x-th class="text-center">
            <span>{{__('the_subject')}}</span>
        </x-th>

        <x-th class="text-center">
            <span>{{__('the_sponsor')}}</span>
        </x-th>

        <x-th class="text-center">
            <span>{{__('sponsor_phone_number')}}</span>
        </x-th>
    </x-slot>

    <x-slot name="tbody">
        @foreach($private_school->eventsWithOrphans as  $key => $value)
            @foreach($value->orphans as $orphan)
                @php
                    $counter++;
                @endphp
                <tr>
                    <x-td class="text-center">
                        {{ $counter }}
                    </x-td>

                    <x-td class="text-center">
                        {{ $orphan->getName() }}
                    </x-td>

                    <x-td class="text-center">
                        {{ $private_school->subjects[$key]['academicLevel']['level'] }}
                    </x-td>

                    <x-td class="text-center">
                        {{ $private_school->subjects[$key]['subject']['ar_name'] }}
                    </x-td>

                    <x-td class="text-center">
                        {{ $orphan->sponsor->getName() }}
                    </x-td>

                    <x-td class="text-center">
                        {{ formatPhoneNumber($orphan->sponsor->phone_number) }}
                    </x-td>
                </tr>
            @endforeach
        @endforeach
    </x-slot>
</x-table>
