# ProxyJsonView for DietCake

## What is this?

`Controller` 内で生成した値をテンプレートファイルを介して `JSON` 形式で出力するための `View` クラス

## Installation

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "git://github.com/dietcake_proxy-json-view.git"
        }
    ],
    "require": {
        "dietcake/dietcake_proxy-json-view": "dev-master"
    }
}
```

## Usage

```php
<?php
class HomeController extends Controller
{
    public $default_view_class = 'ProxyJsonView';

    public function index()
    {
        $this->set('name', 'John Doe');
    }
}
```

```php
<?php
$response = array(
    'name' => $name,
);
```

## Output
```json
{"name": "John Doe"}
```
