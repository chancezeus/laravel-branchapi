<?php

namespace ChanceZeus\BranchApi\Types;

abstract class Enum
{
    /** @var array */
    private static $constCacheArray = [];

    /** @var array */
    private static $instances = [];

    /** @var string */
    private $name;

    /** @var $value */
    private $value;

    /**
     * Enum constructor.
     *
     * @param string $name
     * @param mixed $value
     */
    private function __construct(string $name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Gets an instance of the enum based on the (constant) value
     *
     * @param mixed $value
     * @return static
     */
    public static function instance($value): Enum
    {
        $calledClass = get_called_class();

        self::$instances[$calledClass] = self::$instances[$calledClass] ?? [];

        $values = self::getConstants();
        $name = array_search($value, $values, true);

        if ($name === false) {
            throw new \InvalidArgumentException("{$value} is not a valid " . static::class);
        }

        if (!array_key_exists($name, self::$instances[$calledClass][$name])) {
            self::$instances[$calledClass][$name] = new static($name, $value);
        }

        return self::$instances[$calledClass][$name];
    }

    /**
     * Validates the given name
     *
     * @param string $name
     * @param bool $strict
     * @return bool
     */
    public static function isValid(string $name, bool $strict = false): bool
    {
        $values = self::getConstants();

        if ($strict) {
            return array_key_exists($name, $values);
        }

        return in_array(strtolower($name), array_map('strtolower', array_keys($values)));
    }

    /**
     * @return array
     */
    private static function getConstants()
    {
        $calledClass = get_called_class();

        if (!array_key_exists($calledClass, self::$constCacheArray)) {
            $reflect = new \ReflectionClass($calledClass);
            self::$constCacheArray[$calledClass] = $reflect->getConstants();
        }

        return self::$constCacheArray[$calledClass];
    }
}
