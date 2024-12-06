@foreach ($data as $phaseKey => $academicLevels)
    <h3>{{ __('phase_' . $phaseKey) }}</h3>
    <table border="1">
        <thead>
        <tr>
            <th>Tool</th>
            @foreach ($academicLevels as $academicLevel => $levelData)
                <th colspan="3">{{ $academicLevel }}</th>
            @endforeach
            <th colspan="3">Row Total</th>
        </tr>
        <tr>
            <th></th>
            @foreach ($academicLevels as $academicLevel => $levelData)
                <th>Male</th>
                <th>Female</th>
                <th>Total</th>
            @endforeach
            <th>Male</th>
            <th>Female</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        @php
            // Collect all unique tools across all academic levels
            $tools = collect($academicLevels)->flatMap(fn($data) => $data['tools'])->pluck('name')->unique();
        @endphp

        @foreach ($tools as $toolName)
            <tr>
                <td>{{ $toolName }}</td>
                @php
                    $rowMaleTotal = 0;
                    $rowFemaleTotal = 0;
                    $rowGlobalTotal = 0;
                @endphp

                @foreach ($academicLevels as $academicLevel => $levelData)
                    @php
                        $tool = collect($levelData['tools'])->firstWhere('name', $toolName);
                        $male = $tool['male'] ?? 0;
                        $female = $tool['female'] ?? 0;
                        $total = $tool['total'] ?? 0;

                        $rowMaleTotal += $male;
                        $rowFemaleTotal += $female;
                        $rowGlobalTotal += $total;
                    @endphp
                    <td>{{ $male }}</td>
                    <td>{{ $female }}</td>
                    <td>{{ $total }}</td>
                @endforeach

                <td>{{ $rowMaleTotal }}</td>
                <td>{{ $rowFemaleTotal }}</td>
                <td>{{ $rowGlobalTotal }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endforeach
