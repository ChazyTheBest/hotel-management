<?php declare(strict_types=1);

namespace App\Traits;

use InvalidArgumentException;

trait WithCompositeKey
{
    /**
     * Set the keys for a save update query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<static> $query
     * @return \Illuminate\Database\Eloquent\Builder<static>
     */
    protected function setKeysForSaveQuery($query): \Illuminate\Database\Eloquent\Builder
    {
        $keys = $this->getKeyName();

        if (!is_array($keys)) {
            throw new InvalidArgumentException('The key name (primaryKey) must be an array.');
        }

        return array_reduce(
            $keys,
            fn ($q, $key) => $q->where($key, '=', $this->getAttribute($key)),
            $query
        );
    }

    /**
     * Find a model by its primary key.
     *
     * @param array $attributes
     * @param array $columns
     * @return TModel|null
     */
    public static function find(array $attributes, array $columns = ['*'])
    {
        $instance = new static;

        // Get the key names from the model
        $keyNames = $instance->getKeyNames();

        // Ensure the number of provided attributes matches the number of key names
        if (count($keyNames) !== count($attributes)) {
            throw new InvalidArgumentException('The number of provided attributes does not match the number of primary keys.');
        }

        // Ensure all key names are present in the provided attributes
        foreach ($keyNames as $keyName) {
            if (!array_key_exists($keyName, $attributes)) {
                throw new InvalidArgumentException("Missing value for key: $keyName");
            }
        }

        // Create a query to find the model instance
        $query = $instance->newQuery();
        $query->where($attributes);

        // Execute the query and return the first result
        return $query->first($columns);
    }
}
