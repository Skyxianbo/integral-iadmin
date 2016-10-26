<?php

$application = [
    'controllersDir'             => __DIR__ . '/../controllers/',

    'modelsDir'                  => __DIR__ . '/../models/',
    'modelsVitabeeDir'           => __DIR__ . '/../models/admin/',
    'modelsVitabeeAdminDir'      => __DIR__ . '/../models/mall/',
    'modelsVitabeeContentDir'    => __DIR__ . '/../models/supplier/',
    'modelsVitabeeLikeDir'       => __DIR__ . '/../models/distributor/',

    'servicesDir'                => __DIR__ . '/../services/',
    'servicesDatabaseDir'        => __DIR__ . '/../services/database/',
    'servicesAliDir'             => __DIR__ . '/../services/ali/',
    'servicesTencentDir'         => __DIR__ . '/../services/tencent/',

    'vendorDir'                  => __DIR__ . '/../vendor/',

    'viewsDir'                   => __DIR__ . '/../views/',

    'pluginsDir'                 => __DIR__ . '/../plugins/',

    'libraryDir'                 => __DIR__ . '/../library/',

    'cacheDir'                   => __DIR__ . '/../cache/',

    'baseUri'                    => '/',
];

if (IS_DEV) {
    $application['base_url']    = '';
    $application['v2_base_url'] = '';
} else {
    $application['base_url']    = '';
    $application['v2_base_url'] = '';
}
