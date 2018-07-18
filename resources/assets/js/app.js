import './bootstrap';
// import router from './routes';
import RegisterModal from './components/RegisterModalComponent';
import LoginModal from './components/LoginModalComponent';
import Home from './views/home';
import Create from './views/create';
import Profile from './views/profile';

new Vue({
  el: '#app',
  data: {
    login: false,
    id: 0,
    name: '',
    email: '',
    age: '',
    gender: '',
    error: false
  },
  //router: router,
  components: {
    'home': Home,
    'create': Create,
    'profile': Profile
  },
  methods: {
    setUserSession(user) {
      this.login = true;
      this.id = user.id;
      this.name = user.name;
      this.email = user.email;
      this.age = user.age;
      this.gender = user.gender;
    },
    onLogout() {
      this.login = false;
      this.id = 0;
      this.name = '';
      this.email = '';
      this.age = '';
      this.gender = '';
    },
    updateProfile(profile) {
      this.age = profile.age;
      this.gender = profile.gender;
      this.name = profile.name;
    }
  },
  created() {
    var vueObject = this;
    axios({
      method: 'get',
      url: '/retrieve_session'
    }).then(function(response) {
      console.log(response.data);
      var user = response.data;
      if(user != '') {
        vueObject.setUserSession(user);
      } else {
        vueObject.onLogout();
      }
    });
  }
});
