import { router } from '../routes/routes';

/**
 * This Controller class will keep contact with the route "action" on Server-side and Vue components on
 * Client-side.
 * We usually see the Controller run on server-side, contact to Action classes by importing module
 * and get request through HTTP request from client side. However, in this website it is different
 * Controller class will run on client side. IT will be invoked by Vue Router, a JS dependency installed by npm;
 *  and contact to route "action" (Just a php file configed for this role, not a class) by HTTP requests.
 */
export class Controller {
    constructor() { };

    /**  *
     * This function will filter the rows of table
     * which have content relatively matched the value of "#myInput"
     */
    filterTable(input, table) {
        // Declare variables
        let filter, tr, tds;
        filter = input.value.toUpperCase();
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (let i = 0; i < tr.length; i++) {
            tds = tr[i].getElementsByTagName("td");
            let txtValues = [];
            for (let j = 0; j < tds.length; j++) {
                txtValues.push(tds[j].textContent || tds[j].innerText);
            }
            for (let j = 0; j < tds.length - 1; j++) {
                if (txtValues[j].toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                    // console.log(txtValues[j]);
                    // console.log(filter);
                    break;
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    /** Load the list of User instances in JSON */
    async loadUsersList() {
        let users_list = [];
        await fetch(window.location.origin + "/action/all_users")
            .then((response) => response.text())
            .then((res) => {
                users_list = JSON.parse(res);
            })
        return users_list;
    }

    /**
     * Find the user who are Logging in
     */
    async findLoggedInUser() {
        let user = null;
        await fetch(window.location.origin + "/action/current_user")
            .then((response) => ((response.status == 200) ? response.text() : response.status))
            .then((res) => {
                if (isNaN(res)) {
                    user = JSON.parse(res);
                }
            });
        // THis localStorage param will be use in route file
        window.current_user = user;
        console.log(window.current_user);
        return user;
    }

    /** Load the list of Quiz instances in JSON */
    async loadQuizzesList() {
        let list = [];
        await fetch(window.location.origin + "/action/all_quizzes")
            .then((response) => response.text())
            .then((res) => {
                list = JSON.parse(res);
            })
        return list;
    }

    /** Load the list of Quiz instances which have the specified user_id in JSON */
    async loadQuizzesListByUserID(user_id) {
        let list = [];
        await fetch(window.location.origin + "/action/all_quizzes_with_user_id/" + user_id)
            .then((response) => response.text())
            .then((res) => {
                list = JSON.parse(res);
            })
        return list;
    }

    /** Load the list of Quiz instances which have the specified user_id in JSON */
    async loadQuizzesListByQuizID(quiz_id) {
        let list = [];
        await fetch(window.location.origin + "/action/all_quizzes_with_user_id/" + quiz_id)
            .then((response) => response.text())
            .then((res) => {
                list = JSON.parse(res);
            })
        return list;
    }


    /**
     * send AJAX request to create new QUiz instance, the requests sent have method POST, PUT, DELETE
     * @param string path link path
     * @param FormData form_datas a FormData object is submit (if the method is POST or PUT or DELETE)
     * @param string method is ( POST, PUT, DELETE); default is POST
     */
    async sendAPI(path, form_datas, method = "POST") {
        let result = null;
        // console.log(form_datas.get('name'));
        await fetch(window.location.origin + path, {
            body: form_datas,
            method: method.toUpperCase(),
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            }
        }).then((response) => ((response.status == 200) ? response.text() : response.status))
            .then((res) => {
                result = res;
            });
        return result;
    }


    /** Load the list of Questions instances in JSON */
    async loadQuestionsList() {
        let list = [];
        await fetch(window.location.origin + "/action/all_questions")
            .then((response) => response.text())
            .then((res) => {
                list = JSON.parse(res);
            })
        return list;
    }

    /** Read Question by id (Question object in JSON) */
    async readQuestionByID(id) {
        let question = null;
        // console.log(id);
        await fetch(window.location.origin + "/action/find_question/" + id)
            .then(response => ((response.status == 200) ? response.text() : response.status))
            .then(res => {
                question = (isNaN(res)) ? JSON.parse(res) : res;
            })
        return question;
    }

    /** Read Quiz by id (Quiz object in JSON) */
    async readQuizByID(id) {
        let quiz = null;
        // console.log(id);
        await fetch(window.location.origin + "/action/find_quiz/" + id)
            .then(response => ((response.status == 200) ? response.text() : response.status))
            .then(res => {
                quiz = (isNaN(res)) ? JSON.parse(res) : res;
            })
        return quiz;
    }

    /** Load the list of Exams instances in JSON */
    async loadExamsList() {
        let list = [];
        await fetch(window.location.origin + "/action/all_exams")
            .then((response) => response.text())
            .then((res) => {
                list = JSON.parse(res);
            })
        return list;
    }

    /** Load the list of Answer instances in JSON */
    async loadAnswersList() {
        let list = [];
        await fetch(window.location.origin + "/action/all_answers")
            .then((response) => response.text())
            .then((res) => {
                list = JSON.parse(res);
            })
        return list;
    }

    /** Load the list of Answer instances in JSON */
    async loadResultsList() {
        let list = [];
        await fetch(window.location.origin + "/action/all_results")
            .then((response) => response.text())
            .then((res) => {
                list = JSON.parse(res);
            })
        return list;
    }

    /**  Find the Result Object in JSON by its id */
    async readResultByID(id) {
        let result = null;
        await fetch(window.location.origin + "/action/find_result/" + id)
            .then(response => ((response.status == 200) ? response.text() : response.status))
            .then(res => {
                result = (isNaN(res)) ? JSON.parse(res) : res;
            })
        return result;
    }

    /**  Find the Result Object in JSON by its user 's id */
    async readResultByUserID(user_id) {
        let result = null;
        await fetch(window.location.origin + "/action/find_result/user/" + user_id)
            .then(response => ((response.status == 200) ? response.text() : response.status))
            .then(res => {
                result = (isNaN(res)) ? JSON.parse(res) : res;
            })
        return result;
    }

    /**  Find the Result Object in JSON by its quiz id */
    async readResultByQuizID(quiz_id) {
        let result = null;
        await fetch(window.location.origin + "/action/find_result/quiz/" + quiz_id)
            .then(response => ((response.status == 200) ? response.text() : response.status))
            .then(res => {
                result = (isNaN(res)) ? JSON.parse(res) : res;
            })
        return result;
    }

    /** Read User by id (User object from Backend in JSON) */
    async readUserByID(id) {
        let user = null;
        // console.log(id);
        await fetch(window.location.origin + "/action/find_user/" + id)
            .then(response => ((response.status == 200) ? response.text() : response.status))
            .then(res => {
                user = (isNaN(res)) ? JSON.parse(res) : res;
            })
        return user;
    }

    /** Find the next (Auto Completed) ID */
    async find_next_id(table_name) {
        let next_id = null;
        await fetch(window.location.origin + "/action/find_next_id/" + table_name)
            .then(response => ((response.status == 200) ? response.text() : 'fail'))
            .then((res) => {
                next_id = (!isNaN(res)) ? res : -1;
            })
        return next_id;
    }

}
