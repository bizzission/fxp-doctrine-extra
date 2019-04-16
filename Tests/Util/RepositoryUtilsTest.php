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

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectManager;
use Fxp\Component\DoctrineExtra\Tests\Fixtures\Entity\Repository\MockRepository;
use Fxp\Component\DoctrineExtra\Util\RepositoryUtils;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class RepositoryUtilsTest extends TestCase
{
    public function testGetRepository()
    {
        /* @var ObjectManager|MockObject $om */
        $om = $this->getMockBuilder(ObjectManager::class)->getMock();

        $om->expects($this->once())
            ->method('getRepository')
            ->with(\stdClass::class)
            ->willReturn(new MockRepository());

        /* @var ManagerRegistry|MockObject $doctrine */
        $doctrine = $this->getMockBuilder(ManagerRegistry::class)->getMock();

        $doctrine->expects($this->once())
            ->method('getManagerForClass')
            ->with(\stdClass::class)
            ->willReturn($om);

        $repo = RepositoryUtils::getRepository($doctrine, \stdClass::class, MockRepository::class);
        $this->assertInstanceOf(MockRepository::class, $repo);
    }

    /**
     * @expectedException \Fxp\Component\DoctrineExtra\Exception\ObjectManagerNotFoundException
     * @expectedExceptionMessage The doctrine manager for the "stdClass" class is not found
     */
    public function testGetRepositoryWithNoManager()
    {
        /* @var ObjectManager|MockObject $om */
        $om = $this->getMockBuilder(ObjectManager::class)->getMock();

        /* @var ManagerRegistry|MockObject $doctrine */
        $doctrine = $this->getMockBuilder(ManagerRegistry::class)->getMock();

        $doctrine->expects($this->once())
            ->method('getManagerForClass')
            ->with(\stdClass::class)
            ->willReturn(null);

        RepositoryUtils::getRepository($doctrine, \stdClass::class, MockRepository::class);
    }

    /**
     * @expectedException \Fxp\Component\DoctrineExtra\Exception\UnexpectedRepositoryException
     * @expectedExceptionMessage The doctrine repository of the "stdClass" class is not an instance of the "Fxp\Component\DoctrineExtra\Tests\Fixtures\Entity\Repository\MockRepository"
     */
    public function testGetRepositoryWithInvalidRepositoryClass()
    {
        /* @var ObjectManager|MockObject $om */
        $om = $this->getMockBuilder(ObjectManager::class)->getMock();

        $om->expects($this->once())
            ->method('getRepository')
            ->with(\stdClass::class)
            ->willReturn(new \stdClass());

        /* @var ManagerRegistry|MockObject $doctrine */
        $doctrine = $this->getMockBuilder(ManagerRegistry::class)->getMock();

        $doctrine->expects($this->once())
            ->method('getManagerForClass')
            ->with(\stdClass::class)
            ->willReturn($om);

        RepositoryUtils::getRepository($doctrine, \stdClass::class, MockRepository::class);
    }
}
