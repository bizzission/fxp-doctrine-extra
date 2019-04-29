<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\DoctrineExtra\Util;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Mapping\ClassMetadata as OrmClassMetadata;
use Fxp\Component\DoctrineExtra\Exception\ObjectManagerNotFoundException;

/**
 * Utils for doctrine manager.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class ManagerUtils
{
    /**
     * Get the doctrine object manager of the class.
     *
     * @param ManagerRegistry $or    The doctrine registry
     * @param string          $class The class name or doctrine shortcut class name
     *
     * @return ObjectManager|null
     */
    public static function getManager(ManagerRegistry $or, $class)
    {
        $manager = $or->getManagerForClass($class);

        if (null === $manager) {
            foreach ($or->getManagers() as $objectManager) {
                if ($objectManager->getMetadataFactory()->hasMetadataFor($class)
                        && static::isValidManager($objectManager, $class)) {
                    $manager = $objectManager;
                    break;
                }
            }
        }

        return $manager;
    }

    /**
     * Get the required object manager.
     *
     * @param ManagerRegistry $or    The doctrine registry
     * @param string          $class The class name
     *
     * @return ObjectManager
     *
     * @throws ObjectManagerNotFoundException When the class is not registered in doctrine
     */
    public static function getRequiredManager(ManagerRegistry $or, $class)
    {
        $manager = static::getManager($or, $class);

        if (null === $manager) {
            throw ObjectManagerNotFoundException::create($class);
        }

        return $manager;
    }

    /**
     * Check if the object manager is valid.
     *
     * @param ObjectManager $manager The object manager
     * @param string        $class   The class name
     *
     * @return bool
     */
    private static function isValidManager(ObjectManager $manager, $class)
    {
        $meta = $manager->getClassMetadata($class);

        return !$meta instanceof OrmClassMetadata || !$meta->isMappedSuperclass;
    }
}
