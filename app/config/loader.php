<?php

$loader = new \Phalcon\Loader();

/*
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
    array(
        $config->application->controllersDir,
        $config->application->modelsDir,
        $config->application->libraryDir,
    )
);

//注册命名空间
$loader->registerNamespaces(
    array(
        'App\Controllers'        => $config->application->controllersDir,

        'App\Models'             => $config->application->modelsDir,
        'App\Models\Admin'       => $config->application->modelsAdminDir,
        'App\Models\Mall'        => $config->application->modelsMallDir,
        'App\Models\Supplier'    => $config->application->modelsSupplierDir,
        'App\Models\Distributor' => $config->application->modelsDistributorDir,

        'App\Library'            => $config->application->libraryDir,
        'App\Services'           => $config->application->servicesDir,
        'App\Services\Ali'       => $config->application->servicesAliDir,
        'App\Services\Database'  => $config->application->servicesDatabaseDir,
        'App\Services\Tencent'   => $config->application->servicesTencentDir,
    )
);

$loader->register();
