import Vue from "vue";
import VueRouter from 'vue-router';

Vue.use(VueRouter);

//ルーティングに必要なコンポーネントのimport
import TaskListComponent from "./components/TaskListComponent";
import TaskShowComponent from "./components/TaskShowComponent";
import TaskCreateComponent from "./components/TaskCreateComponent";
import TaskEditComponent from "./components/TaskEditComponent";
import LoginComponent from "./components/LoginComponent";
import CreateThreadComponent from "./components/thread/CreateThreadComponent";
import ThreadsComponent from "./components/thread/ThreadsComponent";

//URLと↑でimportしたコンポーネントをマッピングする（ルーティング設定
const router = new VueRouter({
    mode: 'history',
    routes: [
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
            path: '/login',
            name: 'login',
            component: LoginComponent,
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



   ]
   
});

export default router;