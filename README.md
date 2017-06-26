# Api

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]


## Install

Via Composer in `composer.json`


```
"repositories": [
    {
        "type":"vcs",
        "url":"git@git.iw.sv:it/api-lumen.git"
    }
],
"require": {
    "iw/api":"dev-master"
},
```

Register provider

```
Iw\Api\ApiServiceProvider::class,
```

**Note:** if you are using lumen, make sure to uncomment `$app->withFacades();` and `$app->withEloquent();` in `bootstrap/app.php`

## Configuration

To set the secret used to protect the API, add this to the `.env` file

```
IW_API_JWT_SECRET=mysupersecret
```

## Usage

To protect an endpoint for the api, you make use of `auth_token` middleware.

```php
<?php

namespace App\Http\Controllers;

class ExampleController extends Controller
{
    use \Iw\Api\Traits\Http\JsonResponders;

    public function __construct()
    {
      $this->middleware('auth_token');
    }

    public function info()
    {

    }
}
```

To require the node `data` in the request, you make use of `data_required` middleware.

```
<?php

namespace App\Http\Controllers;

class ExampleController extends Controller
{
    use \Iw\Api\Traits\Http\JsonResponders;

    public function __construct()
    {
      $this->middleware('auth_token');
      $this->middleware('data_required');
    }

    public function info()
    {

    }
}
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email emilio@ideaworks.la instead of using the issue tracker.

## Credits

- [Iw][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/Iw/Api.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/Iw/Api/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/Iw/Api.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/Iw/Api.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/Iw/Api.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/Iw/Api
[link-travis]: https://travis-ci.org/Iw/Api
[link-scrutinizer]: https://scrutinizer-ci.com/g/Iw/Api/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/Iw/Api
[link-downloads]: https://packagist.org/packages/Iw/Api
[link-author]: https://github.com/iw
[link-contributors]: ../../contributors
