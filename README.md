# Autodesk OAuth2 Provider for Laravel Socialite

### 1. Installation

`composer require varz62/socialite-autodesk`

### 2. Service Provider

* Remove `Laravel\Socialite\SocialiteServiceProvider` from your `providers[]` array in `config\app.php` if you have added it already.
* Add `SocialiteProviders\Manager\ServiceProvider` to your `providers[]` array in `config\app.php`.

For example:
```php
'providers' => [
    // a whole bunch of providers
    // remove 'Laravel\Socialite\SocialiteServiceProvider',
    SocialiteProviders\Manager\ServiceProvider::class, // add
];
```
* Note: If you would like to use the Socialite Facade, you need to [install it](http://laravel.com/docs/5.2/authentication#social-authentication).

### 3. Add the Event and Listeners

* Add `SocialiteProviders\Manager\SocialiteWasCalled::class` event to your `listen[]` array in `<app_name>/Providers/EventServiceProvider`.

* Add your listeners (i.e. the ones from the providers) to the `SocialiteProviders\Manager\SocialiteWasCalled[]` that you just created.

* The listener that you add for this provider is `Varz62\SocialiteProviders\Autodesk\AutodeskExtendSocialite::class`.

* Note: You do not need to add anything for the built-in socialite providers unless you override them with your own providers.

For example:
```php
/**
 * The event handler mappings for the application.
 *
 * @var array
 */
protected $listen = [
    SocialiteProviders\Manager\SocialiteWasCalled::class => [
        Varz62\SocialiteProviders\Autodesk\AutodeskExtendSocialite::class
    ],
];
```

### 4. Services Array and .env

Add to `config/services.php`:
```php
'autodesk' => [
        'client_id' => env('AUTODESK_KEY'),
        'client_secret' => env('AUTODESK_SECRET'),
        'redirect_uri' => env('AUTODESK_REDIRECT_URI'),
    ],
```

Append provider values to your `.env` file:
```
// other values above
AUTODESK_KEY=your_app_id_for_the_service
AUTODESK_SECRET=your_app_secret_for_the_service
AUTODESK_REDIRECT_URI=https://example.com/login
```
