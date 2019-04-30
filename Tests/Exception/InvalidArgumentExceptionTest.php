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

use Fxp\Component\DoctrineExtra\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class InvalidArgumentExceptionTest extends TestCase
{
    public function testException(): void
    {
        $exception = new InvalidArgumentException('FOO');

        $this->assertInstanceOf(InvalidArgumentException::class, $exception);
        $this->assertSame('FOO', $exception->getMessage());
    }
}
