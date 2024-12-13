<?php

/**
 * @see https://github.com/artesaos/seotools
 */

return [
    'meta' => [
        /*
         * The default configurations to be used by the meta generator.
         */
        'defaults'       => [
            'title'        => "Professional Photography Studio, Abu dhabi", // set false to total remove
            'titleBefore'  => false, // Put defaults.title before page title, like 'Abu dhabi. - Dashboard'
            'description'  => 'Professional Photography Studio specializing in business portraits, event photography, and video production in Abu Dhabi.', // set false to total remove
            'separator'    => ' - ',
            'keywords'     => [],
            'canonical'    => null, // Set to null or 'full' to use Url::full(), set to 'current' to use Url::current(), set false to total remove
            'robots'       => 'all', // Set to 'all', 'none' or any combination of index/noindex and follow/nofollow
        ],
        /*
         * Webmaster tags are always added.
         */
        'webmaster_tags' => [
            'google'    => null,
            'bing'      => null,
            'alexa'     => null,
            'pinterest' => null,
            'yandex'    => null,
            'norton'    => null,
        ],

        'add_notranslate_class' => false,
    ],
    'opengraph' => [
        /*
         * The default configurations to be used by the opengraph generator.
         */
        'defaults' => [
            'title'       => 'Professional Photography Studio, Abu dhabi', // set false to total remove
            'description' => 'Professional Photography Studio specializing in business portraits, event photography, and video production in Abu Dhabi.', // set false to total remove
            'url'         => null, // Set null for using Url::current(), set false to total remove
            'type'        => 'ProfessionalService',
            'site_name'   => 'Strap Studios',
            'images'      => [
                'https://www.strapstudios.com/frontend/assets/images/strap_studio_logo.png',
            ],
        ],
    ],
    'twitter' => [
        /*
         * The default values to be used by the twitter cards generator.
         */
        'defaults' => [
            'card'        => 'summary',
            'site'        => '@StrapStudios',
        ],
    ],
    'json-ld' => [
        /*
         * The default configurations to be used by the json-ld generator.
         */

        'defaults' => [
            'title'       => 'Professional Photography Studio, Abu dhabi', // set false to total remove
            'description' => 'Professional Photography Studio specializing in business portraits, event photography, and video production in Abu Dhabi.', // set false to total remove
            'url'         => 'https://www.strapstudios.com', // Set to null or 'full' to use Url::full(), set to 'current' to use Url::current(), set false to total remove
            'type'        => 'ProfessionalService',
            'images'      => [
                [
                    '@type'   => 'ImageObject',
                    'url'     => 'https://www.strapstudios.com/frontend/assets/images/strap_studio_logo.png',
                    'width'   => 800,
                    'height'  => 600,
                ],
            ],
            'telephone'   => '+97126772216',
            'email'       => 'strapstudios@gmail.com',
            'address'     => [
                '@type'           => 'PostalAddress',
                'streetAddress'   => '1704 - ADCP Business Tower C, Electra Street',
                'addressLocality' => 'Abu Dhabi',
                'addressRegion'   => 'Abu Dhabi',
                'addressCountry'  => 'United Arab Emirates',
                'postalCode'      => '00000',
            ],
            'sameAs'      => [
                'https://www.facebook.com/StrapStudios',
                'https://www.instagram.com/StrapStudios',
                'https://www.x.com/StrapStudios',
            ],
            'aggregateRating' => [
                '@type'       => 'AggregateRating',
                'ratingValue' => '4.7',
                'reviewCount' => '25',
                'bestRating'  => '5',
            ],
            'review'      => [
                [
                    '@type'       => 'Review',
                    'reviewRating' => [
                        '@type'       => 'Rating',
                        'ratingValue' => '5',
                        'bestRating'  => '5',
                    ],
                    'author'      => [
                        '@type' => 'Person',
                        'name'  => 'Tarik Manoar',
                    ],
                    'reviewBody'  => 'Excellent service! The photos were professional and exceeded expectations.',
                ],
            ],
            'serviceType' => [
                'Business Portrait Photography',
                'Event Photography',
                'Video Production',
            ],
        ],
    ],
];
