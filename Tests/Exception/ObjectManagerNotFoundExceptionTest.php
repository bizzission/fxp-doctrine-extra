<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\DoctrineExtra\Tests\Util;

use Fxp\Component\DoctrineExtra\Exception\ObjectManagerNotFoundException;
use PHPUnit\Framework\TestCase;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class ObjectManagerNotFoundExceptionTest extends TestCase
{
    public function testException()
    {
        $exception = ObjectManagerNotFoundException::create(\stdClass::class);

        $this->assertInstanceOf(ObjectManagerNotFoundException::class, $exception);
        $this->assertSame('The doctrine manager for the "stdClass" class is not found', $exception->getMessage());
    }
}
