<?php

namespace Database\Factories;

use App\Models\Preview;
use Illuminate\Database\Eloquent\Factories\Factory;

class PreviewFactory extends Factory
{
    protected $model = Preview::class;

    public function definition(): array
    {
        return [
            'created_at' => now(),
            'updated_at' => now(),
            'report' => $this->generateReportContent(),
            'preview_date' => now(),
            'family_id' => fake()->uuid,
            'tenant_id' => fake()->uuid,
        ];
    }

    private function generateReportContent(): string
    {
        $sections = [
            'Executive Summary',
            'Introduction',
            'Methodology',
            'Results',
            'Discussion',
            'Conclusion',
            'Recommendations',
            'Appendix',
        ];

        $content = '';

        foreach ($sections as $section) {
            $content .= '<h2>'.$section.'</h2>';

            $numberOfParagraphs = rand(2, 5);

            for ($i = 0; $i < $numberOfParagraphs; $i++) {
                $content .= '<p>'.fake('ar_SA')->realText(1000).'</p>';
            }

            if ($section == 'Results') {
                $numberOfTables = rand(1, 3);

                for ($j = 0; $j < $numberOfTables; $j++) {
                    $numberOfRows = rand(5, 10);
                    $tableHeaders = ['Column 1', 'Column 2', 'Column 3'];
                    $content .= '<table>';
                    $content .= '<tr><th>'.implode('</th><th>', $tableHeaders).'</th></tr>';

                    for ($k = 0; $k < $numberOfRows; $k++) {
                        $tableRow = [];

                        foreach ($tableHeaders as $header) {
                            $tableRow[] = fake('ar_SA')->word;
                        }
                        $content .= '<tr><td>'.implode('</td><td>', $tableRow).'</td></tr>';
                    }
                    $content .= '</table>';
                }
            }
        }

        return $content;
    }
}
