<?php

namespace Alentejo\Http;


class Response{
  private $httpCode = 200;
  private $headers = [];
  private $body;
  private $contentType;
  private $content;
  public function __construct($httpCode, $content, $contentType = 'text/html'){
    $this->httpCode = $httpCode;
    $this->content = $content;
    $this->contentType = $contentType;
  }

  public function setContentType($contentType){
    $this->contentType = $contentType;
    $this->addHeader('Content-Type', $contentType);
  }
  public function addHeader($key, $value){
    $this->headers[$key] = $value;
  }

  private function addCorsPolicy(){
    $this->addHeader('Access-Control-Allow-Origin', '*');
    $this->addHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    $this->addHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
  }
  private function sendHeaders(){
    $this->addCorsPolicy();
    http_response_code($this->httpCode);
    foreach($this->headers as $key=>$value){
      header($key.': '.$value);
    }
  }

  public function sendResponse(){
    
    $this->sendHeaders();
    switch ($this->contentType) {
      case 'text/html':
        echo $this->content;
        exit;      
      default:
        break;
    }
  }
}