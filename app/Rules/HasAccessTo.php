<?php
declare(strict_types=1);

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Model;

/**
 * Class HasAccessTo
 * @package App\Rules
 */
class HasAccessTo implements Rule
{
    private Model $model;
    private string $relationship;
    private string $columnName;

    /**
     * HasAccessTo constructor.
     * @param Model $model
     * @param string $relationship
     * @param string $columnName
     */
    public function __construct(Model $model, string $relationship, string $columnName = 'id')
    {
        $this->model = $model;
        $this->relationship = $relationship;
        $this->columnName = $columnName;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return $this->model
            ->{$this->relationship}()
            ->where(sprintf('%s.%s', $this->relationship, $this->columnName), $value)
            ->firstOrFail() !== null;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'The validation error message.';
    }
}
