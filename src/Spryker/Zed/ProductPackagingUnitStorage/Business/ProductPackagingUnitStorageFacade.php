<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductPackagingUnitStorage\Business;

use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Spryker\Zed\ProductPackagingUnitStorage\Business\ProductPackagingUnitStorageBusinessFactory getFactory()
 * @method \Spryker\Zed\ProductPackagingUnitStorage\Persistence\ProductPackagingUnitStorageEntityManagerInterface getEntityManager()
 * @method \Spryker\Zed\ProductPackagingUnitStorage\Persistence\ProductPackagingUnitStorageRepositoryInterface getRepository()
 */
class ProductPackagingUnitStorageFacade extends AbstractFacade implements ProductPackagingUnitStorageFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param array<int> $productConcreteIds
     *
     * @return void
     */
    public function publishProductPackagingUnit(array $productConcreteIds): void
    {
        $this->getFactory()
            ->createProductPackagingUnitStorageWriter()
            ->publishProductPackagingUnit($productConcreteIds);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param array<int> $productConcreteIds
     *
     * @return void
     */
    public function unpublishProductPackagingUnit(array $productConcreteIds): void
    {
        $this->getFactory()
            ->createProductPackagingUnitStorageWriter()
            ->unpublishProductPackagingUnit($productConcreteIds);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param array<int> $productPackagingUnitTypeIds
     *
     * @return array<int>
     */
    public function findProductIdsByProductPackagingUnitTypeIds(array $productPackagingUnitTypeIds): array
    {
        return $this->getFactory()
            ->getProductPackagingUnitFacade()
            ->findProductIdsByProductPackagingUnitTypeIds($productPackagingUnitTypeIds);
    }
}
