import { router } from '../routes/routes';


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



}
