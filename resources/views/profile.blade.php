@extends ('layouts/app')

@section ('content')
<div class="container-fluid p-3 pb-5" v-cloak>
  <div class="alert alert-danger alert-dismissible" v-if="error">@{{ error }}<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>
  <profile :age="age" :gender="gender" :name="name" :user_id="id" :app_url="'{{ env('APP_URL') }}'" @profile-updated="updateProfile">

  </profile>
</div>
@endsection
