<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'companies',
		'companies/*',
		'brands',
		'brands/*',
		'location_types',
		'location_types/*',
		'locations',
		'locations/*',
		'users',
		'users/*',
		'palettes',
		'palettes/*',
		'lots',
		'lots/*',
		'materials',
		'materials/*',
        'products',
		'products/*',
    ];
}
