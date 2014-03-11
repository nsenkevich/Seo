<?php

namespace Seo;

return array(
    'router' => array(
        'routes' => array(
            'seo' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/seo',
                    'defaults' => array(
                        'controller' => 'seoController',
                        'action' => 'list',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'add' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route' => '/add',
                            'defaults' => array(
                                'action' => 'add',
                            ),),),
                    'update' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/update[/:id]',
                            'constraints' => array(
                                'id' => '[0-9]+',
                            ),
                            'defaults' => array(
                                'action' => 'update',
                            ),),),
                    'remove' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/remove[/:id]',
                            'constraints' => array(
                                'id' => '[0-9]+',
                            ),
                            'defaults' => array(
                                'action' => 'remove',
                            ),),),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
