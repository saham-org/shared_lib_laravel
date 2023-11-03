<?php

namespace Saham\SharedLibs\Traits;

trait Enumerable {}
// {
//     public static function values(): array
//     {
//         $cases = static::cases();

//         return isset($cases[0]) && $cases[0] instanceof BackedEnum
//             ? array_column($cases, 'value')
//             : array_column($cases, 'name');
//     }

//     public function names(): array
//     {
//         return array_column(static::cases(), 'name');
//     }

//     public static function fromKey(string $key): self
//     {
//         if (static::hasKey($key)) {
//             $enumValue = static::getValue($key);

//             return new static($enumValue);
//         }

//         throw new \InvalidArgumentException("Invalid key: {$key}");
//     }

//     public static function hasKey(string $key): bool
//     {
//         return in_array($key, static::getKeys(), true);
//     }

//     public static function getKeys($values = null): mixed
//     {
//         if ($values === null) {
//             return array_keys(static::getConstants());
//         }

//         return collect(is_array($values) ? $values : func_get_args())
//             ->map(static function ($value) {
//                 return static::getKey($value);
//             })
//             ->toArray();
//     }

//     protected static function getConstants(): mixed
//     {
//         return self::getReflection()->getConstants();
//     }
// }
