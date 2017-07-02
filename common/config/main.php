<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    /*'site' =>[
        'frontUrl' => 'yii2.loc',
        'bkUrl' => 'bk.yii2.loc',
    ],*/
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
    'modules' => [
        'redactor' => 'yii\redactor\RedactorModule',
    ],
];
