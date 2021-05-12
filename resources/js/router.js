import Vue from "vue";
import VueRouter from 'vue-router';

Vue.use(VueRouter);

//ルーティングに必要なコンポーネントのimport
import TaskListComponent from "./components/TaskListComponent";
import TaskShowComponent from "./components/TaskShowComponent";
import TaskCreateComponent from "./components/TaskCreateComponent";
import TaskEditComponent from "./components/TaskEditComponent";
import CreateThreadComponent from "./components/thread/CreateThreadComponent";
import ThreadsComponent from "./components/thread/ThreadsComponent";
import PostsComponent from "./components/post/PostsComponent";

import RegisterComponent from "./components/user/RegisterComponent";
import LoginComponent from "./components/user/LoginComponent";
import LogoutComponent from "./components/user/LogoutComponent";


//URLと↑でimportしたコンポーネントをマッピングする（ルーティング設定
const router = new VueRouter({
    mode: 'history',
    routes: [
      {
         path: '/register',
         name: 'register',
         component: RegisterComponent,
         meta: {forGuest: true }
      },      
      {
         path: '/login',
         name: 'login',
         component: LoginComponent,
         meta: {forGuest: true }
      },
      {
         path: '/logout',
         name: 'logout',
         component: LogoutComponent,
      },

        {
            path: '/tasks',
            name: 'task.list',
            component: TaskListComponent
        },
        {
           path: '/tasks/:taskId',
           name: 'task.show',
           component: TaskShowComponent,
           props: true
        },
        {
           path: '/tasks/create',
           name: 'task.create',
           component: TaskCreateComponent
        },
        {
           path: '/tasks/:taskId/edit',
           name: 'task.edit',
           component: TaskEditComponent,
           props: true
        },
         {
            path: '/create-thread',
            name: 'create-thread',
            component: CreateThreadComponent,
         },
         {
            path: '/threads',
            name: 'threads',
            component: ThreadsComponent,
         },
         {
            path: '/threads/:thread_id',
            name: 'thread.show',
            component: PostsComponent,
            props: true
         },
         {
            path: '/threads/:thread_id/responses/:displayed_post_id',
            name: 'thread.responses',
            component: PostsComponent,
            props: true
         },

   ] 
   
});

function isLoggedIn() {
   return localStorage.getItem("auth");
}

// router.beforeEach((to, from, next) => {
//    if (to.matched.some(record => record.meta.authOnly)) {
//        if (!isLoggedIn()) {
//            next("/login");
//        } else {
//            next();
//        }
//    } else if (to.matched.some(record => record.meta.guestOnly)) {
//        if (isLoggedIn()) {
//            next("/about");
//        } else {
//            next();
//        }
//    } else {
//        next();
//    }
// });

// router.beforeEach((to, from, next) => {
//    // isPublic でない場合(=認証が必要な場合)、かつ、ログインしていない場合
//    if (to.matched.some(record => !record.meta.isPublic) && !isLoggedIn()) {
//      next({ path: '/login', query: { redirect: to.fullPath }});
//    } else {
//      next();
//    }
//  });

router.beforeEach((to, from, next) => {
   //forGuestがついてないURLへのアクセス
   if (to.matched.some(record => !(record.meta.forGuest))) {
       if (!isLoggedIn()) {
          alert('ログインが必要です。');
           next("/login");
       } else {
          next();
       }
   //forGuestがついているURLへのアクセス
   } else if (to.matched.some(record => record.meta.forGuest)) {
       if (isLoggedIn()) {
           alert('すでにログイン済みです。');
           next("/threads");
       } else {
           next();
       }
   } else {
           next();
       }
});




export default router;