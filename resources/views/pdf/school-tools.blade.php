@foreach ($data['global'] as $phaseKey => $academicLevels)
    <x-table>
        <x-slot name="title">
            <h1 class="text-center">{{ __('school_tools') }}</h1>
            <h3 class="text-center">{{ __('phase_' . $phaseKey) }}</h3>
        </x-slot>

        <x-slot name="thead">
            @if ($loop->first)
                <h3 class="text-center print:hidden"> طباعة في A3</h3>
            @endif
            <tr>
                <x-th>{{ __('school_tools') }}</x-th>
                @foreach ($academicLevels as $academicLevel => $levelData)
                    <th colspan="2" class="font-medium px-1 py-1 border border-black text-balance">{{ $academicLevel }}
                    </th>
                @endforeach
                <x-th colspan="3">{{ __('total_in_each_academic_level') }}</x-th>
            </tr>
            <tr>
                <x-th></x-th>
                @foreach ($academicLevels as $academicLevel => $levelData)
                    <x-th>{{ __('males') }}</x-th>
                    <x-th>{{ __('females') }}</x-th>
                @endforeach
                <x-th>{{ __('males') }}</x-th>
                <x-th>{{ __('females') }}</x-th>
                <x-th>{{ __('the_total') }}</x-th>
            </tr>
        </x-slot>

        <x-slot name="tbody">
            @php
                // Collect all unique tools across all academic levels
                $tools = collect($academicLevels)->flatMap(fn($data) => $data['tools'])->pluck('name')->unique();
            @endphp

            @foreach ($tools as $toolName)
                <tr>
                    <x-td class="text-center">{{ $toolName }}</x-td>
                    @php
                        $rowMaleTotal = 0;
                        $rowFemaleTotal = 0;
                        $rowGlobalTotal = 0;
                    @endphp

                    @foreach ($academicLevels as $academicLevel => $levelData)
                        @php
                            $tool = $levelData['tools']->firstWhere('name', $toolName);
                            $male = $tool['male'] ?? 0;
                            $female = $tool['female'] ?? 0;
                            $total = $tool['total'] ?? 0;

                            $rowMaleTotal += $male;
                            $rowFemaleTotal += $female;
                            $rowGlobalTotal += $total;
                        @endphp
                        <x-td class="text-center">{{ $male }}</x-td>
                        <x-td class="text-center">{{ $female }}</x-td>
                    @endforeach

                    <x-td class="text-center">{{ $rowMaleTotal }}</x-td>
                    <x-td class="text-center">{{ $rowFemaleTotal }}</x-td>
                    <x-td class="text-center">{{ $rowGlobalTotal }}</x-td>
                </tr>
            @endforeach
        </x-slot>
    </x-table>

    @pageBreak
@endforeach

<div class="w-1/2">
    <x-table>
        <x-slot name="title">
            <h1 class="text-center">{{ __('school_tools') }}</h1>
        </x-slot>

        <x-slot name="thead">
            <tr>
                <x-th>{{ __('school_tools') }}</x-th>
                <x-th>{{ __('males') }}</x-th>
                <x-th>{{ __('females') }}</x-th>
                <x-th>{{ __('the_total') }}</x-th>
            </tr>
        </x-slot>

        <x-slot name="tbody">
            @foreach ($data['totals'] as $toolName => $totals)
                <tr>
                    <x-td class="maw-w-40">{{ $toolName }}</x-td>
                    <x-td class="text-center">{{ $totals['male'] }}</x-td>
                    <x-td class="text-center">{{ $totals['female'] }}</x-td>
                    <x-td class="text-center">{{ $totals['total'] }}</x-td>
                </tr>
            @endforeach
        </x-slot>
    </x-table>
</div>

@pageBreak

@foreach ($data['branches'] as $branchId => $branchData)
    @foreach ($branchData['data'] as $phaseKey => $academicLevels)
        <x-table>
            <x-slot name="title">
                <h1 class="text-center">{{ __('school_tools') }}</h1>
                <h3 class="text-center">{{ __('phase_' . $phaseKey) }}</h3>
                <h4 class="text-center">{{ $branchData['branch_name'] }}</h4>
            </x-slot>

            <x-slot name="thead">
                @if ($loop->first)
                    <h3 class="text-center print:hidden"> طباعة في A3</h3>
                @endif
                <tr>
                    <x-th>{{ __('school_tools') }}</x-th>
                    @foreach ($academicLevels as $academicLevel => $levelData)
                        <th colspan="2" class="font-medium px-1 py-1 border border-black text-balance">
                            {{ $academicLevel }}</th>
                    @endforeach
                    <x-th colspan="3">{{ __('total_in_each_academic_level') }}</x-th>
                </tr>
                <tr>
                    <x-th></x-th>
                    @foreach ($academicLevels as $academicLevel => $levelData)
                        <x-th>{{ __('males') }}</x-th>
                        <x-th>{{ __('females') }}</x-th>
                    @endforeach
                    <x-th>{{ __('males') }}</x-th>
                    <x-th>{{ __('females') }}</x-th>
                    <x-th>{{ __('the_total') }}</x-th>
                </tr>
            </x-slot>

            <x-slot name="tbody">
                @php
                    // Collect all unique tools across all academic levels in the branch
                    $tools = collect($academicLevels)->flatMap(fn($data) => $data['tools'])->pluck('name')->unique();
                @endphp

                @foreach ($tools as $toolName)
                    <tr>
                        <x-td class="text-center">{{ $toolName }}</x-td>
                        @php
                            $rowMaleTotal = 0;
                            $rowFemaleTotal = 0;
                            $rowGlobalTotal = 0;
                        @endphp

                        @foreach ($academicLevels as $academicLevel => $levelData)
                            @php
                                $tool = $levelData['tools']->firstWhere('name', $toolName);
                                $male = $tool['male'] ?? 0;
                                $female = $tool['female'] ?? 0;
                                $total = $tool['total'] ?? 0;

                                $rowMaleTotal += $male;
                                $rowFemaleTotal += $female;
                                $rowGlobalTotal += $total;
                            @endphp
                            <x-td class="text-center">{{ $male }}</x-td>
                            <x-td class="text-center">{{ $female }}</x-td>
                        @endforeach

                        <x-td class="text-center">{{ $rowMaleTotal }}</x-td>
                        <x-td class="text-center">{{ $rowFemaleTotal }}</x-td>
                        <x-td class="text-center">{{ $rowGlobalTotal }}</x-td>
                    </tr>
                @endforeach
            </x-slot>
        </x-table>

        @pageBreak
    @endforeach
@endforeach
