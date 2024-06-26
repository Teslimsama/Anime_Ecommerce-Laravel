<?php
return [

    /*
     * The driver to use to interact with MailChimp API.
     * You may use "log" or "null" to prevent calling the
     * API directly from your environment.
     */
    'driver' => env('NEWSLETTER_DRIVER', Spatie\Newsletter\Drivers\MailcoachDriver::class),

    /**
     * These arguments will be given to the driver.
     */
    'driver_arguments' => [
        'api_key' => env('NEWSLETTER_API_KEY'),

        'endpoint' => env('NEWSLETTER_ENDPOINT'),
    ],

    /*
     * The list name to use when no list name is specified in a method.
     */
    'default_list_name' => 'Testech',

    'lists' => [

        /*
         * This key is used to identify this list. It can be used
         * as the listName parameter provided in the various methods.
         *
         * You can set it to any string you want and you can add
         * as many lists as you want.
         */
        'Testech' => [

            /*
             * When using the Mailcoach driver, this should be the Email list UUID
             * which is displayed in the Mailcoach UI
             *
             * When using the MailChimp driver, this should be a MailChimp list id.
             * http://kb.mailchimp.com/lists/managing-subscribers/find-your-list-id.
             */
            'id' => env('NEWSLETTER_LIST_ID'),
        ],
    ],
];
// return [

//     /*
//      * The driver to use to interact with MailChimp API.
//      * You may use "log" or "null" to prevent calling the
//      * API directly from your environment.
//      */
//     'driver' => env('MAILCHIMP_DRIVER', 'api'),

//     /*
//      * The API key of a MailChimp account. You can find yours at
//      * https://us10.admin.mailchimp.com/account/api-key-popup/.
//      */
//     'apiKey' => env('MAILCHIMP_APIKEY'),

//     /*
//      * The listName to use when no listName has been specified in a method.
//      */
//     'defaultListName' => 'subscribers',

//     /*
//      * Here you can define properties of the lists.
//      */
//     'lists' => [

//         /*
//          * This key is used to identify this list. It can be used
//          * as the listName parameter provided in the various methods.
//          *
//          * You can set it to any string you want and you can add
//          * as many lists as you want.
//          */
//         'subscribers' => [

//             /*
//              * A MailChimp list id. Check the MailChimp docs if you don't know
//              * how to get this value:
//              * http://kb.mailchimp.com/lists/managing-subscribers/find-your-list-id.
//              */
//             'id' => env('MAILCHIMP_LIST_ID'),
//         ],
//     ],

//     /*
//      * If you're having trouble with https connections, set this to false.
//      */
//     'ssl' => true,

// ];
