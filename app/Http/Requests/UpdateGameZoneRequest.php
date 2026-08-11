<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateGameZoneRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string', 'max:255'],
            'slug' => ['sometimes', 'string', 'max:255',Rule::unique('game_zones', 'slug')->ignore($this->route('gameZone'))],
            'icon' => ['sometimes', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'difficulty' => ['sometimes', Rule::in(['Easy', 'Medium', 'Hard'])],
            'reward_coins' => ['sometimes', 'integer', 'min:0'],
            'reward_xp' => ['sometimes', 'integer', 'min:0'],
            'is_active' => ['sometimes', 'boolean'],
            'sort_order' => ['sometimes', 'integer', 'min:0'],
        ];
    }
}
