<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\ProductPackagingUnitStorage;

use Spryker\Client\Kernel\AbstractDependencyProvider;
use Spryker\Client\Kernel\Container;
use Spryker\Client\ProductPackagingUnitStorage\Dependency\Client\ProductPackagingUnitStorageToProductMeasurementUnitStorageClientBridge;
use Spryker\Client\ProductPackagingUnitStorage\Dependency\Client\ProductPackagingUnitStorageToStorageClientBridge;
use Spryker\Client\ProductPackagingUnitStorage\Dependency\Service\ProductPackagingUnitStorageToSynchronizationServiceBridge;

class ProductPackagingUnitStorageDependencyProvider extends AbstractDependencyProvider
{
    /**
     * @var string
     */
    public const CLIENT_STORAGE = 'CLIENT_STORAGE';

    /**
     * @var string
     */
    public const CLIENT_PRODUCT_MEASUREMENT_UNIT_STORAGE = 'CLIENT_PRODUCT_MEASUREMENT_UNIT_STORAGE';

    /**
     * @var string
     */
    public const SERVICE_SYNCHRONIZATION = 'SERVICE_SYNCHRONIZATION';

    /**
     * @var string
     */
    public const SERVICE_UTIL_ENCODING = 'SERVICE_UTIL_ENCODING';

    public function provideServiceLayerDependencies(Container $container): Container
    {
        $container = parent::provideServiceLayerDependencies($container);

        $container = $this->addStorageClient($container);
        $container = $this->addSynchronizationService($container);
        $container = $this->addUtilEncodingService($container);
        $container = $this->addProductMeasurementUnitStorageClient($container);

        return $container;
    }

    protected function addStorageClient(Container $container): Container
    {
        $container->set(static::CLIENT_STORAGE, function (Container $container) {
            return new ProductPackagingUnitStorageToStorageClientBridge($container->getLocator()->storage()->client());
        });

        return $container;
    }

    protected function addProductMeasurementUnitStorageClient(Container $container): Container
    {
        $container->set(static::CLIENT_PRODUCT_MEASUREMENT_UNIT_STORAGE, function (Container $container) {
            return new ProductPackagingUnitStorageToProductMeasurementUnitStorageClientBridge(
                $container->getLocator()->productMeasurementUnitStorage()->client(),
            );
        });

        return $container;
    }

    protected function addSynchronizationService(Container $container): Container
    {
        $container->set(static::SERVICE_SYNCHRONIZATION, function (Container $container) {
            return new ProductPackagingUnitStorageToSynchronizationServiceBridge($container->getLocator()->synchronization()->service());
        });

        return $container;
    }

    protected function addUtilEncodingService(Container $container): Container
    {
        $container->set(static::SERVICE_UTIL_ENCODING, function (Container $container) {
            return $container->getLocator()->utilEncoding()->service();
        });

        return $container;
    }
}
