import Vue from "vue";
import VueRouter from 'vue-router';

Vue.use(VueRouter);

//ルーティングに必要なコンポーネントのimport
import TaskListComponent from "./components/TaskListComponent";
import TaskShowComponent from "./components/TaskShowComponent";
import TaskCreateComponent from "./components/TaskCreateComponent";
import TaskEditComponent from "./components/TaskEditComponent";
//threads
import CreateThreadComponent from "./components/thread/CreateThreadComponent";
import ThreadsComponent from "./components/thread/ThreadsComponent";
//posts
import PostsComponent from "./components/post/PostsComponent";
//users
import ProfileComponent from "./components/users/ProfileComponent.vue"
//Auth
import RegisterComponent from "./components/auth/RegisterComponent";
import LoginComponent from "./components/auth/LoginComponent";
import LogoutComponent from "./components/auth/LogoutComponent";
//setting
import SettingNameComponent from "./components/setting/SettingNameComponent";
import SettingConfirmComponent from "./components/setting/SettingConfirmComponent";
import SettingPersonalComponent from "./components/setting/SettingPersonalComponent";


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
        //threads
         {
            path: '/threads/create',
            name: 'threads/create',
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
         //users
         {
            path: '/users/:user_id/posts',
            name: 'user.posts',
            component: ProfileComponent,
            props: true
         },
         {
            path: '/users/:user_id/likes',
            name: 'user.likes',
            component: ProfileComponent,
            props: true
         },
         {
            path: '/users/:user_id/threads',
            name: 'user.threads',
            component: ProfileComponent,
            props: true
         },
         //setting
         {
            path: '/setting/account/name',
            name: 'setting.name',
            component: SettingNameComponent,
         },
         {
            path: '/setting/account/confirm',
            name: 'setting.confirm',
            component: SettingConfirmComponent,
         },
         {
            path: '/setting/account/personal',
            name: 'setting.personal',
            component: SettingPersonalComponent,
         },



   ] 
   
});

function isLoggedIn() {
   return localStorage.getItem("auth");
}


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