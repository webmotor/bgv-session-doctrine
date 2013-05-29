<?php

$moduleName = 'BgvSessionDoctrine';

return array(
    'doctrine' => array(
        'driver' => array(
            strtolower($moduleName) . '_annotation_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'paths' => array(__DIR__ . '/../src/' . $moduleName . '/Entity'),
            ),
            'orm_default' => array(
                'drivers' => array(
                    $moduleName . '\Entity' => strtolower($moduleName) . '_annotation_driver',
                ),
            ),
        ),
    ),
);