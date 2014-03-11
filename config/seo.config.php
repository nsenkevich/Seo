<?php

namespace Seo;
use Seo\Entity\Seo;

return array(
    'seo' => array(
        'seo_routes' => array(
            //route with id => seoType
            'jobShow' => Seo::JOB,
            'builderShow' => Seo::BUILDER,
            'homeownerfront' => Seo::HOMEOWNER
        ),
    ),
);
