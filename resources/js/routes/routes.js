import VueRouter from "vue-router";
import DashboardComponent from '../components/DashboardComponent.vue';
import TableQuizzesComponent from '../components/table_component/TableQuizzesComponent.vue';
import TableExamsComponent from '../components/table_component/TableExamsComponent.vue';
import TableUsersComponent from '../components/table_component/TableUsersComponent.vue';
import TableQuestionsComponent from '../components/table_component/TableQuestionsComponent.vue';
import CreateQuizComponent from '../components/form_component/quiz/CreateQuizComponent.vue';
import EditQuizComponent from '../components/form_component/quiz/EditQuizComponent.vue';
import DeleteQuizComponent from '../components/form_component/quiz/DeleteQuizComponent.vue';
import DeleteQuestionComponent from "../components/form_component/question/DeleteQuestionComponent.vue";
import EditQuestionComponent from '../components/form_component/question/EditQuestionComponent.vue';
import CreateQuestionComponent from '../components/form_component/question/CreateQuestionComponent.vue';

const routes = [
    {
        path: "/vue/dashboard", name: "dashboard", component: DashboardComponent,
        children: [
            { path: "quizzes", name: "quizzes", component: TableQuizzesComponent },
            { path: "users", name: "users", component: TableUsersComponent },
            { path: "questions", name: "questions", component: TableQuestionsComponent },
            { path: "exams", name: "exams", component: TableExamsComponent },
        ]

    },
    {
        path: "/vue/create_quiz", name: "create_quiz", component: CreateQuizComponent
    },
    {
        path: "/vue/create_question", name: "create_question", component: CreateQuestionComponent
    },
    {
        path: "/vue/edit_quiz/:id", name: "edit_quiz", component: EditQuizComponent
    },
    {
        path: "/vue/edit_question/:id", name: "edit_question", component: EditQuestionComponent
    },
    {
        path: "/vue/delete_quiz/:id", name: "delete_quiz", component: DeleteQuizComponent
    },
    {
        path: "/vue/delete_question/:id", name: "delete_question", component: DeleteQuestionComponent
    },
    {
        path: "/home", redirect: "/vue/dashboard"
    }
];

export const router = new VueRouter({
    // Mode 'history' to avoid the "#" showing on the path of route
    mode: 'history',
    routes: routes
});
