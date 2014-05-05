<?php
/**
 * @package GoogleURLShortener
 * @copyright Propeople Ukraine
 * @license MIT, <https://github.com/BR0kEN-/goo.gl/blob/master/LICENSE>
 * @version 0.1.9, May 5, 2014
 * @link https://github.com/BR0kEN-/goo.gl
 * @source https://github.com/BR0kEN-/goo.gl/blob/master/lib/GoogleURLShortener.php
 * @author BR0kEN <broken@firstvector.org>
 */
class GoogleURLShortener {
  private
    $request = 'https://www.googleapis.com/urlshortener/v1/url?',
    $method,
    $curl;

  public function __construct($key = false) {
    $this->curl = curl_init();

    if ($key) {
      $this->request .= "key=$key&";
    }

    curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);

    return $this;
  }

  public function __destruct() {
    if (curl_error($this->curl) !== '') {
      curl_close($this->curl);
    }
  }

  public function prepare($url) {
    $this->method = strpos($url, '//goo.gl') !== false;
    $method = $this->method ? 'expand' : 'shorten';

    return $this->$method($url);
  }

  public function execute() {
    $data = json_decode(curl_exec($this->curl));

    if ($data->error) {
      throw new \RuntimeException($data->error->message);
    }

    return $data ? ($this->method ? $data->longUrl : $data->id) : false;
  }

  protected function shorten($url) {
    curl_setopt_array($this->curl, array(
      CURLOPT_URL => $this->request,
      CURLOPT_POST => true,
      CURLOPT_POSTFIELDS => json_encode(array('longUrl' => $url)),
      CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
      CURLOPT_RETURNTRANSFER => true,
    ));

    return $this;
  }

  protected function expand($url) {
    curl_setopt_array($this->curl, array(
      CURLOPT_URL => $this->request . http_build_query(array('shortUrl' => $url)),
      CURLOPT_HTTPGET => true,
      CURLOPT_RETURNTRANSFER => true,
    ));

    return $this;
  }
}
