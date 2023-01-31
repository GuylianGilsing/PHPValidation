<?php

declare(strict_types=1);

use DG\BypassFinals;
use PHPUnit\Framework\TestCase;

/**
 * Class that enables mocking final classes in PHPUnit.
 *
 * @link https://tomasvotruba.com/blog/2019/03/28/how-to-mock-final-classes-in-phpunit/
 */
abstract class BypassFinalsTestCase extends TestCase
{
    /**
     * @param int|string $dataName
     *
     * @internal This method is not covered by the backward compatibility promise for PHPUnit
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        BypassFinals::enable();
    }
}
