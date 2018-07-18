<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ProductController extends Controller {

  public $productAPI;

  public function __construct() {
    $this->productAPI = 'http://itemku.productapi/';
  }

  public function index() {
    return view('index');
  }

  public function new() {
    return view('create');
  }

  public function show(Request $request) {
    $client = new Client();
    $res = $client->request('GET', $this->productAPI.'api/product');
    $result = json_decode($res->getBody());
    return $result;
  }

  public function getImgSrc() {
    return 'http://itemku.productapi/img/';
  }

  public function generateForm($request, $patch = false) {
    $form = array();
    $requestData = $request->only(['name', 'category', 'price', 'discount', 'description']);
    $requestData['userID'] = session('id');
    if($patch) $requestData['_method'] = 'PATCH';
    $form['query'] = $requestData;
    $form['headers'] = ['Authorization' => apache_request_headers()['Authorization']];
    if($request->hasFile('image')) {
      $form['multipart'] = [['name' => 'image', 'contents' => fopen($request->only(['image'])['image']->getPathName(), 'r')]];
    }
    return $form;
  }

  public function create(Request $request) {
    $client = new Client();
    $form = $this->generateForm($request);
    $res = $client->request('POST', $this->productAPI.'api/product', $form);
    return $res->getBody();
  }

  public function update(Request $request, $id) {
    $client = new Client();
    $form = $this->generateForm($request, true);
    $res = $client->request('POST', $this->productAPI.'api/product/'.$id, $form);
    return $res->getBody();
  }

  public function destroy(Request $request, $id) {
    $client = new Client();
    $form = $this->generateForm($request);
    $res = $client->request('DELETE', $this->productAPI.'api/product/'.$id, $form);
    return $res->getBody();
  }
}
