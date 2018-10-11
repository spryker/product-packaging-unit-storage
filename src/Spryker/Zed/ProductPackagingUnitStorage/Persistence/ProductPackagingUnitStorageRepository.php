<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductPackagingUnitStorage\Persistence;

use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \Spryker\Zed\ProductPackagingUnitStorage\Persistence\ProductPackagingUnitStoragePersistenceFactory getFactory()
 */
class ProductPackagingUnitStorageRepository extends AbstractRepository implements ProductPackagingUnitStorageRepositoryInterface
{
    /**
     * @param int[] $productAbstractIds
     *
     * @return \Generated\Shared\Transfer\SpyProductAbstractPackagingStorageEntityTransfer[]
     */
    public function findProductAbstractPackagingUnitStorageByProductAbstractIds(array $productAbstractIds): array
    {
        if (!$productAbstractIds) {
            return [];
        }

        $query = $this->getFactory()
            ->createSpyProductAbstractPackagingStorageQuery()
            ->filterByFkProductAbstract_In($productAbstractIds);

        return $this->buildQueryFromCriteria($query)->find();
    }

    /**
     * @module ProductPackagingUnit
     *
     * @param int $idProductAbstract
     *
     * @return \Generated\Shared\Transfer\SpyProductEntityTransfer[]
     */
    public function findPackagingProductsByProductAbstractId(int $idProductAbstract): array
    {
        if (!$idProductAbstract) {
            return [];
        }

        $query = $this->getFactory()
            ->getSpyProductQuery()
                ->filterByFkProductAbstract($idProductAbstract)
                ->filterByIsActive(true)
            ->innerJoinWithSpyProductAbstract()
            ->innerJoinWithSpyProductPackagingUnit()
            ->useSpyProductPackagingUnitQuery()
                ->leftJoinWithSpyProductPackagingUnitAmount()
                ->innerJoinWithProductPackagingUnitType()
            ->endUse()
            ->orderByCreatedAt();

        return $this->buildQueryFromCriteria($query)->find();
    }

    /**
     * @param int[] $productAbstractIds
     *
     * @return \Generated\Shared\Transfer\SpyProductPackagingLeadProductEntityTransfer[]
     */
    public function getProductPackagingLeadProductEntitiesByProductAbstractIds(array $productAbstractIds): array
    {
        $query = $this->getFactory()
            ->getSpyProductPackagingLeadProductQuery()
            ->filterByFkProductAbstract_In($productAbstractIds)
            ->useSpyProductQuery()
                ->filterByIsActive(true)
            ->endUse();

        return $this->buildQueryFromCriteria($query)->find();
    }

    /**
     * @return \Generated\Shared\Transfer\SpyProductAbstractPackagingStorageEntityTransfer[]
     */
    public function findAllProductAbstractPackagingUnitStorageEntities(): array
    {
        $query = $this->getFactory()->createSpyProductAbstractPackagingStorageQuery();

        return $this->buildQueryFromCriteria($query)->find();
    }
}
