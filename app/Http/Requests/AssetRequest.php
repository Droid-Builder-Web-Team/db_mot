<?php
/**
 * Asset Request
 * php version 8.2
 *
 * @category Controller
 * @package  Controllers
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Enums\AssetTypes;
use App\Enums\AssetConditions;

class AssetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->hasRole(['Super Admin', 'Org Admin', 'Quartermaster']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'description' => 'required',
            'owner_id' => 'required',
            'current_holder_id' => 'required',
            'current_state' => [ Rule::enum(AssetConditions::class)],
            'type' => [ Rule::enum(AssetTypes::class)]
        ];
    }
}
