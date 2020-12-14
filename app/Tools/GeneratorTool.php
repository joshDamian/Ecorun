<?php
declare(strict_types = 1);

namespace App\Tools;

use \Exception;

class GeneratorTool
{
    public static $limitIterations = 100000;

    /**
    * @param string $column
    * @param string $modelClass
    * @return string
    * @throws GeneratorException
    */
    public static function generateID(string $modelClass, string $column, array $whereParams = [], string $append = null): string
    {
        return self::run(
            $modelClass,
            $column,
            self::IDGenerator(),
            'Generation id is failed. The loop limit exceeds ' . self::$limitIterations,
            $whereParams,
            $append
        );
    }

    /**
    * @param string     $modelClass
    * @param string     $column
    * @param \Generator $generator
    * @param string     $exceptionMessage
    * @param array      $whereParams
    * @return string
    * @throws GeneratorException
    */

    protected static function run(string $modelClass, string $column, \Generator $generator, string $exceptionMessage, array $whereParams = [], $append = null): string
    {
        try {
            foreach ($generator as $id) {
                $query = $modelClass::where([$column => ($append) ? $append.$id : $id]);
                foreach ($whereParams as $param) {
                    $query->where(...$param);
                }
                if (!$query->first()) {
                    return ($append) ? $append.$id : $id;
                }
            }
        } catch (\Throwable $e) {
            $exceptionMessage = $e->getMessage();
        }

        throw new Exception($exceptionMessage);
    }

    protected static function IDGenerator(): ?\Generator
    {
        for ($i = 1; $i <= self::$limitIterations; $i++) {
            yield (string) random_int(10, 999999999);
        }
        return null;
    }
}