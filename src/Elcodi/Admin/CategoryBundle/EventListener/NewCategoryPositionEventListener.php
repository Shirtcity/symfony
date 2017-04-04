<?php

namespace Elcodi\Admin\CategoryBundle\EventListener;

use Doctrine\ORM\Event\PreFlushEventArgs;

use Elcodi\Bundle\CategoryBundle\Entity\Category;

/**
 * Class NewCategoryPositionEventListener sets the position for new categories when these are inserted.
 */
class NewCategoryPositionEventListener
{
    /**
     * Before the flush we check if we are inserting new categories and in this case we set a correct position.
     *
     * @param PreFlushEventArgs $args The pre flush event arguments.
     */
    public function preFlush(PreFlushEventArgs $args)
    {
        $entityManager = $args->getEntityManager();
        $scheduledInsertions = $entityManager->getUnitOfWork()->getScheduledEntityInsertions();

        foreach ($scheduledInsertions as $entity) {
            if ($entity instanceof Category) {
                /**
                 * @var Category $entity
                 */
                $entityRepository = $entityManager->getRepository(get_class($entity));

                if ($entity->isRoot()) {
                    $parentCategoriesNumber = count($entityRepository->getParentCategories());
                    $entity->setPosition($parentCategoriesNumber);
                } else {
                    $categoriesOnThisParentCategory = count($entityRepository->getChildrenCategories(
                        $entity->getParent()
                    ));
                    $entity->setPosition($categoriesOnThisParentCategory);
                }
            }
        }
    }
}
