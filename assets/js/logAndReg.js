$(document).ready(function () {
    $(document).on('click', '#btnRegister', function (e) {
        e.preventDefault()
        userFormRegistrationAndValidation()
    })
    const userFormRegistrationAndValidation = () => {
        const firstName = document.querySelector('#userFirstName').value
        const lastName = document.querySelector('#userLastName').value
        const email = document.querySelector("#userEmail").value
        const password = document.querySelector('#userPassword').value

        if (validationForm().length == 0) {
            $.ajax({
                method: 'post',
                url: 'models/action/register.php',
                data: {
                    firstName: firstName,
                    lastName: lastName,
                    email: email,
                    password: password
                }, dataType: 'json',
                success: function (data, statusTxt, xhr) {
                    if (xhr.status == 201) {
                        window.location.href = 'index.php?page=login'
                    }
                }, error: function (jqXHR, statusTxt, xhr) {
                    printResponseMessages(jqXHR.status, jqXHR.responseJSON, '#registerResponseErrorMessage', 'warning,danger')
                }
            })
        }

    }

    const validationForm = () => {
        const firstName = document.querySelector('#userFirstName').value
        const lastName = document.querySelector('#userLastName').value
        const email = document.querySelector("#userEmail").value
        const password = document.querySelector('#userPassword').value

        const reFirstLastName = /^[A-ZŠĐČĆŽ][a-zšđžčć]{3,15}(\s[A-ZČŠĐĆŽ][a-zčćšđž]{3,15})+$/
        const reEmail = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/
        const rePassword = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/

        const errors = []
        if (!reFirstLastName.test(firstName)) {
            errors.push(firstName)
            createValidationErrorMessage('#userFirstNameErrorMessage', 'text-danger', "First name of user isn't ok")
        } else {
            removeValidationErrrorMessage('#userFirstNameErrorMessage', 'text-danger')
        }
        if (!reFirstLastName.test(lastName)) {
            errors.push(lastName)
            createValidationErrorMessage('#userLastNameErrorMessage', 'text-danger', "Last name of user isn't ok")
        } else {
            removeValidationErrrorMessage("#userLastNameErrorMessage", 'text-danger')
        }
        if (!reEmail.test(email)) {
            errors.push(errors)
            createValidationErrorMessage('#userEmailErrorMessage', 'text-danger', "Email of user isn't ok")
        } else {
            removeValidationErrrorMessage('#userEmailErrorMessage', 'text-danger')
        }
        if (!rePassword.test(password)) {
            errors.push(password)
            createValidationErrorMessage('#userPasswordErrorMessage', 'text-danger', "Password of user isn't ok")
        } else {
            removeValidationErrrorMessage('#userPasswordErrorMessage', 'text-danger')
        }
        return errors
    }
    const createValidationErrorMessage = (element, cls, text) => {
        const el = document.querySelector(element)
        el.classList.add(cls)
        el.textContent = text
    }
    const removeValidationErrrorMessage = (element, cls, text) => {
        const el = document.querySelector(element)
        el.textContent = ''
        el.classList.remove(cls)
    }

    const printResponseMessages = (statusCode, message, whereToPlace, colors) => {
        console.log(statusCode)
        const color = colors.split(',')
        const colorYellow = color[0]
        const colorDanger = color[1]
        switch (statusCode) {
            case 404:
                printMessage(message, whereToPlace, colorDanger)
                break;
            case 409:
                printMessage(message, whereToPlace, colorYellow)
                break;
            case 422:
                printMessage(message, whereToPlace, colorDanger)
                break;
            case 500:
                printMessage(message, whereToPlace, colorDanger)
                break;

        }
    }
    const printMessage = (message, whereToPlace, color) => {

        let ispis = ''
        ispis += `
            <div class="alert alert-${color} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `
        $(whereToPlace).html(ispis)
    }

    const NoContent = (message, number) => {
        return `
            <tr>
                <th scope="row" colspan="${number}">${message}</th>
            </tr>
        `
    }
})