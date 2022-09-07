<?php

namespace App\Core;

abstract class Model
{
    /**
     * Contain attribute of model
     */
    protected array $attributes = [];

    /**
     * Contain relations of model
     *
     * @var array<string, self|self[]>
     */
    protected array $relations = [];

    public function __construct($attributes = [])
    {
        $this->attributes = $attributes;
    }

    /** Get table name */
    abstract public static function table(): string;

    public function fill(array $attributes): void
    {
        $this->attributes = $attributes;
    }

    public function save(): bool
    {
        if ($this->exists()) {
            return $this->update();
        }

        return $this->insert();
    }

    /**
     * Set relation of model
     */
    public function setRelation(string $name, self|array $value): void
    {
        $this->relations[$name] = $value;
    }

    /**
     * Delete model from database
     */
    public function delete(): bool
    {
        if (! $this->exists()) {
            return false;
        }

        $statement = sprintf('DELETE FROM %s WHERE id = ?', static::table());

        return Database::delete($statement, [$this->attributes['id']]);
    }

    /**
     * Find single model by id
     */
    public static function find(int $id): ?static
    {
        $statement = sprintf('SELECT * FROM %s WHERE id = ?', static::table());

        $data = Database::select($statement, [$id]);

        if (empty($data)) {
            return null;
        }

        $model = new static($data[0]);

        return $model;
    }

    /**
     * Count all model in database
     */
    public static function count(): int
    {
        $statement = sprintf('SELECT COUNT(*) FROM %s', static::table());

        $data = Database::select($statement);

        return $data[0]['COUNT(*)'];
    }

    /**
     * Get many models
     *
     * @return static[]
     */
    public static function select(string $concatenationStatement = '', array $data = []): array
    {
        $statement = sprintf('SELECT * FROM %s %s', static::table(), $concatenationStatement);

        $data = Database::select($statement, $data);

        $models = [];

        foreach ($data as $item) {
            $models[] = new static($item);
        }

        return $models;
    }

    /**
     * Handle magic method get
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->attributes)) {
            return $this->attributes[$name];
        }

        if (array_key_exists($name, $this->relations)) {
            return $this->relations[$name];
        }
    }

    /**
     * Handle magic method set
     */
    public function __set($name, $value): void
    {
        $this->attributes[$name] = $value;
    }

    /**
     * Determine if model exists in database
     */
    protected function exists(): bool
    {
        return isset($this->attributes['id']);
    }

    /**
     * Insert new model to database
     */
    protected function insert(): bool
    {
        $attributes = $this->attributes;
        unset($attributes['id']);

        $columns = array_keys($attributes);
        $values = array_values($attributes);

        $statement = sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            static::table(),
            implode(', ', $columns),
            implode(', ', array_fill(0, count($columns), '?')),
        );

        $result = Database::insert($statement, $values);

        if ($result) {
            $this->attributes['id'] = Database::connection()->lastInsertId();
        }

        return $result;
    }

    /**
     * Update model to database
     */
    protected function update(): bool
    {
        $attributes = $this->attributes;
        unset($attributes['id']);

        $columns = array_keys($attributes);
        $values = array_values($attributes);

        $statement = sprintf(
            'UPDATE %s SET %s WHERE id = ?',
            static::table(),
            implode(', ', array_map(fn ($column) => "$column = ?", $columns)),
        );

        $values[] = $this->attributes['id'];

        return Database::update($statement, $values);
    }
}
