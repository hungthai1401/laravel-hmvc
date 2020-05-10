# Laravel-HMVC

## Install
To install through Composer, by run the following command:
```
composer require hungthai1401/laravel-hmvc
```
The package will automatically register a service provider.

Optionally, publish the package's configuration file by running:

```
php artisan vendor:publish --provider="HT\Modules\Providers\ModuleServiceProvider"
```

Update your composer.json
```
{
    ...,
    "repositories": [
        {
            "type": "path",
            "url": "./modules/*"
        },
    ]
}
```

## Usage
### Create new module
```
php artisan module:create <module-name>
```
### Remove a module
```
php artisan module:remove <module-name>
```


