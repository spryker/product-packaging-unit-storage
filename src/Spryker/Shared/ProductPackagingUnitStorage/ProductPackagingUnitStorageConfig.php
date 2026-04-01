<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Shared\ProductPackagingUnitStorage;

use Spryker\Shared\Kernel\AbstractBundleConfig;

class ProductPackagingUnitStorageConfig extends AbstractBundleConfig
{
    /**
     * Specification:
     * - Queue name as used for processing price messages
     *
     * @api
     *
     * @var string
     */
    public const PRODUCT_PACKAGING_UNIT_SYNC_STORAGE_QUEUE = 'sync.storage.product';

    /**
     * Specification:
     * - Queue name as used for processing price messages
     *
     * @api
     *
     * @var string
     */
    public const PRODUCT_PACKAGING_UNIT_SYNC_STORAGE_ERROR_QUEUE = 'sync.storage.product.error';

    /**
     * Specification:
     * - Resource name, this will be used for key generating.
     *
     * @api
     *
     * @var string
     */
    public const PRODUCT_PACKAGING_UNIT_RESOURCE_NAME = 'product_packaging_unit';

    /**
     * Specification:
     * - Queue name used for product packaging unit publish events.
     *
     * @api
     *
     * @var string
     */
    public const string PUBLISH_PRODUCT_PACKAGING_UNIT_QUEUE = 'publish.product_packaging_unit';
}
