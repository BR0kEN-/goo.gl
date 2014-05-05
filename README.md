# goo.gl

**goo.gl** - URL shortener, based on Google Shortener API.

The library can shorten or expand any link. In case, where the link will expand, it should have the correct format, i.e. should being shortened by Google Shortener API previously.

## Usage

```php
$googl = new \GoogleURLShortener;
$googl->prepare('http://firstvector.org/')->execute() === 'http://goo.gl/POsvsj';
$googl->prepare('http://goo.gl/POsvsj')->execute() === 'http://firstvector.org/';
```

Also you can pass the argument to constructor, which must be an API key of Google API. Use with key gives a benefits for creating more requests to API and possible to keep statistics.
