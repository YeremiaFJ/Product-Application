<?php
namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller {

  public $userAPI;

  public function __construct() {
    $this->userAPI = 'http://itemku.userapi/';
  }

  public function profile() {
    if(Auth::id()) return view('profile');
  }

  public function editProfile(Request $request) {
    if(Auth::id()) {
      $user = User::find(Auth::id());
      $user->name = $request->input('name');
      $user->age = $request->input('age');
      $user->gender = $request->input('gender');
      $user->save();
      return $user;
    }
    return null;
  }

  public function retrieveSession() {
    if(Auth::id())
      return User::find(Auth::id());
    else
      return null;
  }

  public function retrieveAPI(Request $request) {
    $query = http_build_query([
      'response_type' => 'code',
      'client_id' => '3',
      'redirect_uri' => 'http://itemku.productnonspa/callback',
      'scope' => '*',
      'state' => session()->getId()
    ]);
    return redirect($this->userAPI.'oauth/authorize?'.$query);
  }

  public function callback(Request $request) {
    if($request->input('state') != session()->getId()) {
      return redirect('/');
    }
    $token = $request->code;
    return redirect($this->userAPI.'get_api_key?url=http://itemku.productnonspa/get_user&code='.$token);
  }

  public function getUser(Request $request) {
    if($request->input('api_key')) {
      $client = new Client();
      $res = $client->request('post', $this->userAPI.'api/authenticate', [
        'headers' => [
          'Authorization' => 'Bearer '.$request->input('api_key')
        ]
      ]);
      $user = json_decode($res->getBody());
      if(!User::find($user->id)) {
        $newProfile = new User();
        $newProfile->id = $user->id;
        $newProfile->name = $user->name;
        $newProfile->save();
      }
      Auth::loginUsingId($user->id);
    }
    return redirect('/');
  }
}
