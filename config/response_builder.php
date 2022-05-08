<?php


use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Validation\ValidationException;
use MarcinOrlowski\ResponseBuilder\Converters\ArrayableConverter;
use MarcinOrlowski\ResponseBuilder\Converters\JsonSerializableConverter;
use MarcinOrlowski\ResponseBuilder\Converters\ToArrayConverter;
use MarcinOrlowski\ResponseBuilder\ExceptionHandlers\HttpExceptionHandler;
use MarcinOrlowski\ResponseBuilder\ExceptionHandlers\ValidationExceptionHandler;


//declare(strict_types=1)


/**
 * Laravel API Response Builder - configuration file
 *
 * See docs/config.md for detailed documentation
 *
 * @author    Marcin Orlowski <mail (#) marcinOrlowski (.) com>
 * @copyright 2016-2022 Marcin Orlowski
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/MarcinOrlowski/laravel-api-response-builder
 *
 * @noinspection PhpCSValidationInspection
 * phpcs:disable Squiz.PHP.CommentedOutCode.Found
 */

return [
    /*
    |-------------------------------------------------------------------------------------------------------------------
    | Code range settings
    |-------------------------------------------------------------------------------------------------------------------
    */
    'min_code' => 100,
    'max_code' => 1024,

    /*
    |-------------------------------------------------------------------------------------------------------------------
    | Error code to message mapping
    |-------------------------------------------------------------------------------------------------------------------
    */
    'map' => [
    ],

    /*
    |-------------------------------------------------------------------------------------------------------------------
    | Response Builder data converter
    |-------------------------------------------------------------------------------------------------------------------
    */
    'converter' => [
        'primitives' => [
            /*
            |-----------------------------------------------------------------------------------------------------------
            | Configuration for primitives used when such data is passed directly as payload (i.e. `success(15)`;)
            |-----------------------------------------------------------------------------------------------------------
            */
            'array' => [
                'key' => 'values',
            ],
            'boolean' => [
                'key' => 'value',
            ],
            'double' => [
                'key' => 'value',
            ],
            'integer' => [
                'key' => 'value',
            ],
            'string' => [
                'key' => 'value',
            ],
        ],

        /*
        |-----------------------------------------------------------------------------------------------------------
        | Object converters configuration for supported classes
        |-----------------------------------------------------------------------------------------------------------
        */
        'classes' => [
            Model::class => [
                'handler' => ToArrayConverter::class,
                'key' => 'item',
                'pri' => 0,
            ],
            \Illuminate\Support\Collection::class => [
                'handler' => ToArrayConverter::class,
                'key' => 'items',
                'pri' => 0,
            ],
            Collection::class => [
                'handler' => ToArrayConverter::class,
                'key' => 'items',
                'pri' => 0,
            ],
            JsonResource::class => [
                'handler' => ToArrayConverter::class,
                'key' => 'item',
                'pri' => 0,
            ],

            /*
            |-----------------------------------------------------------------------------------------------------------
            | Paginators converts to objects already, so we do not array wrapping here, hence setting `key` to null
            |-----------------------------------------------------------------------------------------------------------
            */
            LengthAwarePaginator::class => [
                'handler' => ArrayableConverter::class,
                'key' => null,
                'pri' => 0,
            ],
            Paginator::class => [
                'handler' => ArrayableConverter::class,
                'key' => null,
                'pri' => 0,
            ],

            /*
            |-----------------------------------------------------------------------------------------------------------
            | Generic converters should have lower pri to allow dedicated ones to kick in first when class matches
            |-----------------------------------------------------------------------------------------------------------
            */
            JsonSerializable::class => [
                'handler' => JsonSerializableConverter::class,
                'key' => 'item',
                'pri' => -10,
            ],
            Arrayable::class => [
                'handler' => ArrayableConverter::class,
                'key' => 'items',
                'pri' => -10,
            ],
        ],

    ],

    /*
    |-------------------------------------------------------------------------------------------------------------------
    | Exception handler error codes
    |-------------------------------------------------------------------------------------------------------------------
    */
    'exception_handler' => [
        \Symfony\Component\HttpKernel\Exception\NotFoundHttpException::class => [
            'handler' => HttpExceptionHandler::class,
            'pri' => -100,
            'config' => [
                HttpException::class => [

                    'default' => [
                        'api_code'  => 404,
                        'http_code' => 404,
                    ],
                ],

            ]
        ],

        'exception' => [
            'http_not_found' => ['code' => 404, 'http_code' => 404],
            'http_exception' => ['code' => 404, 'http_code' => 404],
            'uncaught_exception' => ['code' => 404, 'http_code' => 404],
        ],
    ],

    /*
    |-------------------------------------------------------------------------------------------------------------------
    | data-to-json encoding options
    |-------------------------------------------------------------------------------------------------------------------
    */
    'encoding_options' => JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE,

    /*
    |-------------------------------------------------------------------------------------------------------------------
    | If set to TRUE, 'data' element will always be JSON object (even empty, never NULL)
    |-------------------------------------------------------------------------------------------------------------------
    */
    'data_always_object' => false,

    /*
    |-------------------------------------------------------------------------------------------------------------------
    | Debug config
    |-------------------------------------------------------------------------------------------------------------------
    */
    'debug' => [
        'debug_key' => 'debug',
        'exception_handler' => [
            'trace_key' => 'trace',
            'trace_enabled' => env('APP_DEBUG', false),
        ],

        // Controls debugging features of payload converter class.
        'converter' => [
            // Set to true to figure out what converter is used for given data payload and why.
            'debug_enabled' => env('RB_CONVERTER_DEBUG', false),
        ],
    ],

];
