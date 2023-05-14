import { createRouter, createWebHistory } from 'vue-router';

const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: '',
      name: 'get.index',
      component: () => import('./components/Get.vue')
    }, 
    
    {
      path: '/user/login', 
      name: 'user.login',
      component: () => import('./components/auth/Login.vue')
    },

    {
      path: '/user/registration', 
      name: 'user.registration',
      component: () => import('./components/auth/Registration.vue')
    },

    {
      path: '/user/personal/:id', 
      name: 'user.personal',
      component: () => import('./components/auth/Personal.vue')
    },

    {
      path: '/user/addProduct',
      name: 'user.addProduct',
      component: () => import('./components/product/AddProduct.vue')
    },

    {
      path: '/user/checkProduct',
      name: 'user.checkProduct',
      component: () => import('./components/product/CheckProduct.vue')
    },

    {
      path: '/user/readProduct/:id',
      name: 'user.readProduct',
      component: () => import('./components/product/ReadProduct.vue')
    },

    {
      path: '/user/editProduct/:id',
      name: 'user.editProduct',
      component: () => import('./components/product/EditProduct.vue')
    },

    {
      path: '/changeComission',
      name: 'changeComission',
      component: () => import('./components/ChangeComission.vue')
    }

  ]
})

router.beforeEach((to, from, next)=>{
  const token = localStorage.getItem('x-xsrf-token');
  const role = localStorage.getItem('role');

  if (!token){
    if (to.name === 'user.login' || to.name === 'user.registration'){
      return next();
    }
    else{
      return next({
        name: 'user.login'
      })
    }
  }

  if (to.name === 'user.login' || to.name === 'user.registration' && token){
    return next({
      name: 'user.personal'
    })
  }

  if (to.name === 'changeComission' && role != 'admin'){
    return next({
      name: 'get.index'
    })
  }

  next();
})

export default router;