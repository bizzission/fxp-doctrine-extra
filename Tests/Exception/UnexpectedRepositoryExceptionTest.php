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

use Fxp\Component\DoctrineExtra\Exception\UnexpectedRepositoryException;
use PHPUnit\Framework\TestCase;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class UnexpectedRepositoryExceptionTest extends TestCase
{
    public function testException(): void
    {
        $exception = UnexpectedRepositoryException::create(\stdClass::class, 'RepoInterface');

        $this->assertInstanceOf(UnexpectedRepositoryException::class, $exception);
        $this->assertSame('The doctrine repository of the "stdClass" class is not an instance of the "RepoInterface"', $exception->getMessage());
    }
}
