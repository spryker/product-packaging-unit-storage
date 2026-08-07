<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\ProductPackagingUnitStorage;

use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\ProductPackagingUnitStorageCollectionTransfer;
use Generated\Shared\Transfer\ProductPackagingUnitStorageCriteriaTransfer;
use Generated\Shared\Transfer\ProductPackagingUnitStorageTransfer;

interface ProductPackagingUnitStorageClientInterface
{
    /**
     * Specification:
     * - Retrieves a product concrete packaging information for the provided product concrete ID.
     *
     * @api
     *
     * @param int $idProductConcrete
     *
     * @return \Generated\Shared\Transfer\ProductPackagingUnitStorageTransfer|null
     */
    public function findProductPackagingUnitById(int $idProductConcrete): ?ProductPackagingUnitStorageTransfer;

    /**
     * Specification:
     * - Requires `ProductPackagingUnitStorageCriteriaTransfer.productPackagingUnitStorageConditions` to be set.
     * - Uses `ProductPackagingUnitStorageCriteriaTransfer.productPackagingUnitStorageConditions.productIds` to filter by product concrete IDs.
     * - Retrieves product packaging unit storage data filtered by criteria from Storage in a single request.
     * - Returns an empty collection when no product concrete IDs are provided.
     * - Skips product concrete IDs that have no packaging unit in Storage.
     * - Returns `ProductPackagingUnitStorageCollectionTransfer` filled with the found product packaging units.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ProductPackagingUnitStorageCriteriaTransfer $productPackagingUnitStorageCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\ProductPackagingUnitStorageCollectionTransfer
     */
    public function getProductPackagingUnitStorageCollection(
        ProductPackagingUnitStorageCriteriaTransfer $productPackagingUnitStorageCriteriaTransfer
    ): ProductPackagingUnitStorageCollectionTransfer;

    /**
     * Specification:
     * - Expands ItemTransfer with packaging unit data if available.
     * - Uses the default amount and default measurement unit settings.
     * - Returns ItemTransfer unchanged if no packaging unit data is available.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @return \Generated\Shared\Transfer\ItemTransfer
     */
    public function expandItemTransferWithDefaultPackagingUnit(ItemTransfer $itemTransfer): ItemTransfer;
}
