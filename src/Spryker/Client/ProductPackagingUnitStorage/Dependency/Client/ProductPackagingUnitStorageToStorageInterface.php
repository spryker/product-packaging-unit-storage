<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\ProductPackagingUnitStorage\Dependency\Client;

interface ProductPackagingUnitStorageToStorageInterface
{
    /**
     * @param string $key
     *
     * @return array
     */
    public function get($key): array;
}
