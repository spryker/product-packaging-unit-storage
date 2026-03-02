<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductPackagingUnitStorage\Persistence\Mapper;

use Generated\Shared\Transfer\ProductPackagingUnitStorageTransfer;
use Generated\Shared\Transfer\SpyProductPackagingUnitEntityTransfer;

interface ProductPackagingUnitStorageMapperInterface
{
    public function mapProductPackagingUnitStorageEntityTransferToStorageTransfer(
        SpyProductPackagingUnitEntityTransfer $productPackagingUnitEntityTransfer,
        ProductPackagingUnitStorageTransfer $productPackagingUnitStorageTransfer
    ): ProductPackagingUnitStorageTransfer;
}
