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
##### Create new module
```
php artisan module:create <module-name>
```
##### Remove a module
```
php artisan module:remove <module-name>
```
#### Create a controller
```
php artisan module:make:controller <module-name> <controller-name>
```
#### Create a provider
```
php artisan module:make:provider <module-name> <provider-name>
```
#### Create a facade
```
php artisan module:make:facade <module-name> <model-name>
```
#### Create a policy
```
php artisan module:make:policy <module-name> <policy-name>
```
#### Create a event
```
php artisan module:make:event <module-name> <event-name>
```
#### Create a listener
```
php artisan module:make:listener <module-name> <listener-name>
```
#### Create a form request
```
php artisan module:make:request <module-name> <form-request-name>
```
#### Create a job
```
php artisan module:make:job <module-name> <job-name>
```
#### Create a command
```
php artisan module:make:command <module-name> <command-name>
```
#### Create a rule
```
php artisan module:make:rule <module-name> <rule-name>
```
#### Create a service
```
php artisan module:make:service <module-name> <service-name>
```
#### Create a repository
```
php artisan module:make:repository <module-name> <repository-name>
```
#### Create a view
```
php artisan module:make:view <module-name> <view-name>
```
#### Create a view composer
```
php artisan module:make:composer <module-name> <view-composer-name>
```
#### Create a migration
```
php artisan module:make:migration <module-name> <migration-name> --{create|table}
```
#### Create a seeder
```
php artisan module:make:seed <module-name> <seeder-name>
```
#### Create a factory
```
php artisan module:make:factory <module-name> <factory-name>
```

