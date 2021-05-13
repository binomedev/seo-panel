<?php


namespace Binomedev\SeoPanel;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

class Result implements Arrayable, Jsonable
{
    protected array $meta = [];
    protected array $attributes = [];

    /**
     * Report constructor.
     * @param string $name
     * @param bool $status
     */
    public function __construct(string $name, bool $status = false)
    {
        $this->attribute('name', $name);
        $this->attribute('status', $status);

    }

    public function attribute(string $prop, mixed $value = null)
    {
        if (is_null($value)) {
            return array_key_exists($prop, $this->attributes) ? $this->attributes[$prop] : null;
        }

        $this->attributes[$prop] = $value;

        return $this;
    }

    public static function make(...$arguments): static
    {
        return new static(...$arguments);
    }

    public static function failed(string $name): static
    {
        return new static($name, status: false);
    }

    public static function passed(string $name): static
    {
        return new static($name, status: true);
    }

    public static function fromJson(array $data): static
    {
        $result = new static($data['name'], $data['status']);
        $result
            ->message($data['message'])
            ->help($data['help'])
            ->meta($data['meta']);

        return $result;
    }

    public function meta(array $meta = null): array|static
    {
        if (is_null($meta)) {
            return $this->meta;
        }

        $this->meta = array_merge($this->meta, $meta);

        return $this;
    }

    public function help(string $value = null): string|static
    {
        return $this->attribute('help', $value);
    }

    public function message(string $value = null): string|static
    {
        return $this->attribute('message', $value);
    }

    public function name(): string
    {
        return $this->attribute('name');
    }

    public function isFailed(): bool
    {
        return !$this->attribute('status');
    }

    public function isPassed(): bool
    {
        return $this->attribute('status');
    }

    public function hasFailed($message = null): static
    {
        return $this->status(false, $message);
    }

    public function status(bool $passed, string $message = null): static
    {
        $this->attribute('status', $passed);

        if ($message) {
            $this->attribute('message', $message);
        }

        return $this;
    }

    public function hasPassed($message = null): static
    {
        return $this->status(true, $message);
    }

    public function group(string $value = null): string|static
    {
        return $this->attribute('group', $value);
    }

    public function add(string $key, $value)
    {
        return $this->meta[$key] = $value;
    }

    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    public function toArray()
    {
        return array_merge($this->attributes, [
            'meta' => $this->meta,
        ]);
    }
}
