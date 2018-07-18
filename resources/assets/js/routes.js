import VueRouter from 'vue-router';

export default new VueRouter({
  routes: [
    {
      path: '/',
      component: require('./views/home')
    },
    {
      path: '/new-products',
      component: require('./views/create')
    }
  ],
  linkActiveClass: 'active'
});
