/**
 * First we will load Vue Router and all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import VueRouter from "vue-router";
import { router } from "./routes/routes.js";
import { Controller } from "./controllers/controllers.js";
require('./bootstrap');

window.Vue = require('vue');
Vue.use(VueRouter);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/DashboardComponent.vue -> <dashboard-component></dashboard-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('dashboard-component', require('./components/DashboardComponent.vue').default);

// Add event listener for the DOM element on the Sidebar
// First, call all the HTMLElement (<li> tags) objects in sidebar
let dashboardElement = document.querySelector('.sidebar #dashboard');
let createQuizElement = document.querySelector('.sidebar #create_quiz');
let viewQuizzesElement = document.querySelector('.sidebar #view_quizzes');
let viewUsersElement = document.querySelector('.sidebar #view_users');
let createExamElement = document.querySelector('.sidebar #create_exam');
let viewExamElement = document.querySelector('.sidebar #view_exams');
let createQuestionElement = document.querySelector('.sidebar #create_question');
let viewQuestionsElement = document.querySelector('.sidebar #view_questions');
let createAnswerElement = document.querySelector('.sidebar #create_answer');
let viewAnswersElement = document.querySelector('.sidebar #view_answer');

// Get Current Logged in user
let controller = new Controller();
let mixin = null;
// THis is how I run an async function directly on a main JS file
(async function () {
    let current_user = await controller.findLoggedInUser();
    console.log(current_user);
    // Then, append Event Handler for those HTMLElement objects
    // (createUserElement will invoke the ajax for register)
    dashboardElement.addEventListener('click', function (e) {
        e.preventDefault();
        router.push({ name: 'dashboard', params: { current_user: current_user } });
    });

    createQuizElement.addEventListener('click', function (e) {
        e.preventDefault();
        router.push({ name: "create_quiz", params: { current_user: current_user } });
    });

    viewQuizzesElement.addEventListener('click', function (e) {
        e.preventDefault();
        router.push({ name: 'quizzes', params: { current_user: current_user } });
    });

    viewUsersElement.addEventListener('click', function (e) {
        e.preventDefault();
        router.push({ name: 'users', params: { current_user: current_user } });
    });

    createExamElement.addEventListener('click', function (e) {
        e.preventDefault();
        router.push({ name: 'create_exam', params: { current_user: current_user } });
    });

    viewExamElement.addEventListener('click', function (e) {
        e.preventDefault();
        router.push({ name: 'exams', params: { current_user: current_user } });
    });

    createQuestionElement.addEventListener('click', function (e) {
        e.preventDefault();
        router.push({ name: 'create_question', params: { current_user: current_user } });
    });

    viewQuestionsElement.addEventListener('click', function (e) {
        e.preventDefault();
        router.push({ name: 'questions', params: { current_user: current_user } });
    });

    createAnswerElement.addEventListener('click', function (e) {
        e.preventDefault();
        router.push({ name: 'create_answer', params: { current_user: current_user } });
    });

    viewAnswersElement.addEventListener('click', function (e) {
        e.preventDefault();
        router.push({ name: 'answers', params: { current_user: current_user } });
    });

    // Set Global Variables with Vue.Mixin. These variables will be used to pass the Logging in User details
    let mixin = {
        data() {
            return {
                current_user: current_user
            }
        }
    };

    /**
     * Next, we will create a fresh Vue application instance and attach it to
     * the page. Then, you may begin adding components to this application
     * or customize the JavaScript scaffolding to fit your unique needs.
     */

    const app = new Vue({
        el: '#app',
        router: router,
        mixins: [mixin]
    });

})();


