<?php
declare(strict_types=1);

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

/**
 * Class TestCase
 * @package Tests
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Asserts the diff of the arrays is empty
     * @param ...$arrays
     */
    protected static function assertDiffEmpty(...$arrays): void
    {
        self::assertEmpty(self::arrayRecursiveDiff(...$arrays));
    }

    /**
     * @param $aArray1
     * @param $aArray2
     * @return array
     */
    private static function arrayRecursiveDiff($aArray1, $aArray2): array
    {
        $aReturn = [];

        foreach ($aArray1 as $mKey => $mValue) {
            if (array_key_exists($mKey, $aArray2)) {
                if (is_array($mValue)) {
                    $aRecursiveDiff = self::arrayRecursiveDiff($mValue, $aArray2[$mKey]);
                    if (count($aRecursiveDiff)) {
                        $aReturn[$mKey] = $aRecursiveDiff;
                    }
                } else {
                    if ($mValue !== $aArray2[$mKey]) {
                        $aReturn[$mKey] = $mValue;
                    }
                }
            } else {
                $aReturn[$mKey] = $mValue;
            }
        }

        return $aReturn;
    }
}
