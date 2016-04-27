To install via composer
- create composer.json in your project
- add
```json
{
    "repositories": [
      {
        "type": "vcs",
        "url": "https://github.com/ThothMedia/i_can_convert_any_date.git"
      }
    ],
    "require": {
        "thothmedia/tzphp": "v<Version>"
    }

}
```
- run
```shell
composer install
```
