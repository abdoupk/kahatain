<?php

namespace App\Http\Requests\V1\Families;

use App\Rules\VocationalTrainingRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateFamilyRequest extends FormRequest
{
    public function attributes(): array
    {
        return [
            'start_date' => __('filters.starting_sponsorship_date'),
            'housing.number_of_rooms' => __('housing.label.number_of_rooms'),
            'orphans.*.first_name' => __('validation.attributes.first_name'),
            'orphans.*.last_name' => __('validation.attributes.last_name'),
            'orphans.*.birth_date' => __('filters.birth_date'),
            'orphans.*.health_status' => __('health_status'),
            'orphans.*.academic_level_id' => __('academic_level'),
            'orphans.*.pants_size' => __('pants_size'),
            'orphans.*.shoes_size' => __('shoes_size'),
            'orphans.*.shirt_size' => __('shirt_size'),
            'orphans.*.baby_milk_type' => __('baby_milk_type'),
            'orphans.*.baby_milk_quantity' => __('baby_milk_quantity'),
            'orphans.*.diapers_type' => __('diapers_type'),
            'orphans.*.diapers_quantity' => __('diapers_quantity'),
            'orphans.*.vocational_training_id' => __('speciality'),
            'orphans.*.ccp' => __('ccp'),
            'orphans.*.gender' => __('validation.attributes.gender'),
            'orphans.*.phone_number' => __('validation.attributes.phone_number'),
            'sponsor.ccp' => __('ccp'),
            'housing.housing_type.value' => __('housing.label.housing_type_value'),
            'incomes.account.*.balance' => __('incomes.label.balance'),
            'incomes.account.*.performance_grant' => __('incomes.label.performance_grant'),
            'incomes.account.*.monthly_income' => __('incomes.label.monthly_income'),
        ];
    }

    public function rules(): array
    {
        $baby_milk_and_diapers_required = 'required_with:baby_milk_type|required_without:orphans.*.shoes_size
,orphans.*.shirt_size,orphans.*.pants_size';
        $pants_and_shoes_and_shirt_required = 'required_with:orphans.*.shirt_size,orphans.*.pants_size |required_without:orphans.*.baby_milk_quantity,orphans.*.baby_milk_type,orphans.*.diapers_quantity,orphans.*.diapers_type';

        return [
            'submitted' => 'boolean',
            'address' => 'required|string',
            'residence_file' => 'nullable|string',
            'location.lat' => 'nullable|numeric',
            'location.lng' => 'nullable|numeric',
            'zone_id' => 'required|string|exists:App\Models\Zone,id',
            'file_number' => 'required|numeric',
            'start_date' => 'required|date',
            'orphans.*.first_name' => 'required|string',
            'orphans.*.last_name' => 'required|string',
            'orphans.*.birth_date' => 'required|date',
            'orphans.*.family_status' => 'nullable|string',
            'orphans.*.health_status' => 'required|string',
            'orphans.*.academic_level_id' => 'nullable|integer',
            'orphans.*.vocational_training_id' => [new VocationalTrainingRule],
            'orphans.*.gender' => 'required|in:male,female',
            'orphans.*.ccp' => ['nullable', 'string', 'regex:/^\d{12}$/', 'unique:App\Models\Orphan,ccp'],
            'orphans.*.phone_number' => ['nullable', 'string', 'regex:/^(06|07|05)\d{8}$/', 'unique:App\Models\Orphan,phone_number'],
            'sponsor.first_name' => 'required|string',
            'sponsor.last_name' => 'required|string',
            'sponsor.phone_number' => ['required', 'string', 'regex:/^(06|07|05)\d{8}$/', 'unique:App\Models\Sponsor,phone_number'],
            'sponsor.sponsor_type' => 'required|string',
            'sponsor.gender' => 'required|in:male,female',
            'sponsor.birth_date' => 'required|string',
            'sponsor.is_unemployed' => 'required|boolean',
            'sponsor.father_name' => 'required|string',
            'sponsor.mother_name' => 'required|string',
            'sponsor.birth_certificate_number' => 'required|string',
            'sponsor.academic_level_id' => 'nullable|integer',
            'sponsor.function' => 'required|string',
            'sponsor.health_status' => 'required|string',
            'sponsor.diploma' => 'required|string',
            'sponsor.diploma_file' => 'nullable|string',
            'sponsor.photo' => 'nullable|string',
            'sponsor.birth_certificate_file' => 'nullable|string',
            'sponsor.ccp' => ['required', 'string', 'regex:/^\d{12}$/', 'unique:App\Models\Orphan,ccp'],
            'second_sponsor.first_name' => 'nullable|string',
            'second_sponsor.last_name' => 'nullable|string',
            'second_sponsor.phone_number' => 'nullable|string',
            'second_sponsor.degree_of_kinship' => 'nullable|string',
            'second_sponsor.address' => 'nullable|string',
            'second_sponsor.income' => 'nullable|numeric',
            'second_sponsor.with_family' => 'nullable|boolean',
            'spouse.first_name' => 'required|string',
            'spouse.last_name' => 'required|string',
            'spouse.function' => 'required|string',
            'spouse.birth_date' => 'required|string',
            'spouse.death_date' => 'required|string',
            'spouse.death_certificate_file' => 'nullable|string',
            'spouse.income' => 'sometimes|nullable|numeric',
            'incomes.cnr' => 'nullable|numeric',
            'incomes.cnas' => 'nullable|numeric',
            'incomes.casnos' => 'nullable|numeric',
            'incomes.pension' => 'nullable|numeric',
            'incomes.other_income' => 'nullable|numeric',
            'incomes.bank_file' => 'nullable|string',
            'incomes.ccp_file' => 'nullable|string',
            'incomes.cnr_file' => 'nullable|string',
            'incomes.cnas_file' => 'nullable|string',
            'incomes.casnos_file' => 'nullable|string',
            'incomes.account.*.*' => 'nullable|numeric',
            'housing.housing_type.value' => 'required',
            'housing.housing_type.name' => 'required',
            'housing.number_of_rooms' => 'required|numeric',
            'housing.housing_receipt_number' => 'nullable|string',
            'furnishings.*' => 'required',
            'other_properties' => 'nullable|string',
            'inspectors_members' => 'required|array|min:1',
            'preview_date' => 'required|date',
            'inspectors_members.*' => 'required|exists:App\Models\User,id',
            'report' => 'required|string',
            'branch_id' => 'required|exists:App\Models\Branch,id',
            'orphans.*.income' => 'nullable|numeric',
            'orphans.*.shoes_size' => $pants_and_shoes_and_shirt_required,
            'orphans.*.shirt_size' => $pants_and_shoes_and_shirt_required,
            'orphans.*.pants_size' => $pants_and_shoes_and_shirt_required,
            'orphans.*.baby_milk_quantity' => $baby_milk_and_diapers_required,
            'orphans.*.baby_milk_type' => $baby_milk_and_diapers_required,
            'orphans.*.diapers_quantity' => $baby_milk_and_diapers_required,
            'orphans.*.diapers_type' => $baby_milk_and_diapers_required,
            'orphans.*.is_unemployed' => 'required|boolean',
            'orphans.*.is_handicapped' => 'required|boolean',
            'orphans.*.photo' => 'nullable|string',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation(): void
    {
        $this->merge(array_map(function ($value) {
            return $value === null ? false : ($value === '' ? true : $value);
        }, $this->only(['sponsor_sponsorship', 'family_sponsorship'])));
    }
}
