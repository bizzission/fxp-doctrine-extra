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

use Doctrine\ORM\Mapping\ClassMetadata as OrmClassMetadata;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\Mapping\ClassMetadata;
use Doctrine\Persistence\Mapping\ClassMetadataFactory;
use Doctrine\Persistence\ObjectManager;
use Fxp\Component\DoctrineExtra\Util\ManagerUtils;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class ManagerUtilsTest extends TestCase
{
    public function testGetManagerWithInvalidClass(): void
    {
        /** @var ClassMetadataFactory|MockObject $metaFactory */
        $metaFactory = $this->getMockBuilder(ClassMetadataFactory::class)->getMock();

        $metaFactory->expects($this->once())
            ->method('hasMetadataFor')
            ->with('InvalidClass')
            ->willReturn(false)
        ;

        /** @var MockObject|ObjectManager $manager */
        $manager = $this->getMockBuilder(ObjectManager::class)->getMock();
        $manager->expects($this->atLeastOnce())
            ->method('getMetadataFactory')
            ->willReturn($metaFactory)
        ;

        /** @var ManagerRegistry|MockObject $registry */
        $registry = $this->getMockBuilder(ManagerRegistry::class)->getMock();

        $registry->expects($this->once())
            ->method('getManagerForClass')
            ->with('InvalidClass')
            ->willReturn(null)
        ;

        $registry->expects($this->once())
            ->method('getManagers')
            ->willReturn([$manager])
        ;

        $this->assertNull(ManagerUtils::getManager($registry, 'InvalidClass'));
    }

    public function testGetManagerWithValidClass(): void
    {
        /** @var ClassMetadataFactory|MockObject $metaFactory */
        $metaFactory = $this->getMockBuilder(ClassMetadataFactory::class)->getMock();

        $metaFactory->expects($this->once())
            ->method('hasMetadataFor')
            ->with('ValidClass')
            ->willReturn(true)
        ;

        /** @var MockObject|ObjectManager $manager */
        $manager = $this->getMockBuilder(ObjectManager::class)->getMock();
        $manager->expects($this->atLeastOnce())
            ->method('getMetadataFactory')
            ->willReturn($metaFactory)
        ;

        /** @var ManagerRegistry|MockObject $registry */
        $registry = $this->getMockBuilder(ManagerRegistry::class)->getMock();

        $registry->expects($this->once())
            ->method('getManagerForClass')
            ->with('ValidClass')
            ->willReturn(null)
        ;

        $registry->expects($this->once())
            ->method('getManagers')
            ->willReturn([$manager])
        ;

        /** @var ClassMetadata|MockObject $registry */
        $meta = $this->getMockBuilder(ClassMetadata::class)->getMock();

        $manager->expects($this->atLeastOnce())
            ->method('getClassMetadata')
            ->with('ValidClass')
            ->willReturn($meta)
        ;

        $this->assertSame($manager, ManagerUtils::getManager($registry, 'ValidClass'));
    }

    public function testGetManagerWithValidClassButMappedSuperclass(): void
    {
        /** @var MockObject|ObjectManager $manager */
        $manager = $this->getMockBuilder(ObjectManager::class)->getMock();

        /** @var ManagerRegistry|MockObject $registry */
        $registry = $this->getMockBuilder(ManagerRegistry::class)->getMock();

        $registry->expects($this->once())
            ->method('getManagerForClass')
            ->with('ValidClass')
            ->willReturn(null)
        ;

        $registry->expects($this->once())
            ->method('getManagers')
            ->willReturn([$manager])
        ;

        /** @var MockObject|OrmClassMetadata $registry */
        $meta = $this->getMockBuilder(OrmClassMetadata::class)->disableOriginalConstructor()->getMock();
        $meta->isMappedSuperclass = true;

        $manager->expects($this->atLeastOnce())
            ->method('getClassMetadata')
            ->with('ValidClass')
            ->willReturn($meta)
        ;

        $this->assertNull(ManagerUtils::getManager($registry, 'ValidClass'));
    }
}
