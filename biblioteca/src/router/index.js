import Vue from 'vue'
import Router from 'vue-router'
import CreateUser from '@/pages/user/Create'
import IndexUser from '@/pages/user/Index'
import EditUser from '@/pages/user/Edit'
import CreateBook from '@/pages/book/Create'
import IndexBook from '@/pages/book/Index'
import EditBook from '@/pages/book/Edit'
import CreateRent from '@/pages/rent/Create'
import IndexRent from '@/pages/rent/Index'
import EditRent from '@/pages/rent/Edit'


Vue.use(Router)

export default new Router({
  mode: 'history',  
  routes: [
    {
      path: '/',
      name: 'IndexUser',
      component: IndexUser
    },
    {
      path: '/user/create',
      name: 'CreateUser',
      component: CreateUser
    },

    {
      path: '/users/edit/:id',
      name: 'EditUser',
      component: EditUser
    },

    {
      path: '/book',
      name: 'IndexBook',
      component: IndexBook
    },
    {
      path: '/book/create',
      name: 'CreateBook',
      component: CreateBook
    },

    {
      path: '/book/edit/:id',
      name: 'EditBook',
      component: EditBook
    },

    {
      path: '/rent',
      name: 'IndexRent',
      component: IndexRent
    },
    {
      path: '/rent/create',
      name: 'CreateRent',
      component: CreateRent
    },

    {
      path: '/rent/edit/:id',
      name: 'EditRent',
      component: EditRent
    },
  
  ]
})
