<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductPackagingUnitStorage\Business;

interface ProductPackagingUnitStorageFacadeInterface
{
    /**
     * Specification:
     * - Saves the provided product concrete IDs related product packaging unit objects to storage table.
     * - Sends a copy of data to synchronization queue.
     *
     * @api
     *
     * @param array<int> $productConcreteIds
     *
     * @return void
     */
    public function publishProductPackagingUnit(array $productConcreteIds): void;

    /**
     * Specification:
     * - Finds and deletes ProductPackaging storage entities by productConcreteIds
     * - Sends delete message to synchronization queue.
     *
     * @api
     *
     * @param array<int> $productConcreteIds
     *
     * @return void
     */
    public function unpublishProductPackagingUnit(array $productConcreteIds): void;

    /**
     * Specification:
     * - Retrieves the list of product concrete IDs which are associated with any of the provided packaging unit type IDs.
     *
     * @api
     *
     * @param array<int> $productPackagingUnitTypeIds
     *
     * @return array<int>
     */
    public function findProductIdsByProductPackagingUnitTypeIds(array $productPackagingUnitTypeIds): array;
}
