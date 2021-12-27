

$(document).ready(function () {
    let br = 0
    $(document).on('click', '#btnComment', function (e) {
        e.preventDefault();
        let post = $(this).data("post")
        let text = document.querySelector('#comment').value
        $.ajax({
            method: "POST",
            url: "models/comments/insertComment.php",
            data: {
                post: post,
                text: text
            },
            dataType: "json",
            success: function (data) {

                getComments('comments_display', data.user)
                document.querySelector('#comment').value = ""
            },
            error: function (err) {
                console.log(err)
            }
        })
    })

    $(document).on('click', '.read-more', function (e) {
        e.preventDefault()
        let post = $(this).data('post')
        let comment = $(this).data("comment")
        const whereToPlace = `comment${comment}`
        let user = $(this).data("user")
        console.log(document.querySelector(`#${whereToPlace}`))
        // console.log
        br++
        if (br % 2 != 0) {
            document.querySelector(`#btnReadMore${comment}`).textContent = "show less"
            getComments(whereToPlace, comment)
        } else {
            document.querySelector(`#btnReadMore${comment}`).textContent = "show more"
        }
    })

    function getComments(whereToPlace, comment_id) {
        const comment = comment_id != 0 ? comment_id : 0
        const post = window.location.href.split("&")[1].split("=")[1]

        $.ajax({
            method: "get",
            url: 'models/comments/getComments.php',
            data: { comment: comment, post: post },
            dataType: 'json',
            success: function (data) {
                printComments(data, whereToPlace)
            },
            error: function (err) {
                console.log(err)
            }
        })
    }
    $(document).on('click', '.vote-action', function (e) {
        e.preventDefault();
        let post = $(this).data('post')
        let comment = $(this).data('comment')
        let action = $(this).data("action")

        let like = $(this).data('like')
        let disslike = $(this).data('disslike')

        $.ajax({
            method: "POST",
            url: "models/comments/vote.php",
            data: {
                post: post,
                comment: comment,
                action: action
            }, dataType: "json",
            success: function () {
                getVote(comment, action)
            },
            error: function (err) {
                console.log(err)
            }
        })
    })
    const getVote = (comment, action) => {

        $.ajax({
            method: 'get',
            url: "models/comments/getVote.php",
            data: {
                comment_id: comment,
                action: action
            },
            dataType: 'json',
            success: function (data) {

                printVote(comment, data, action)
            },
            error: function (err) {
                console.log(err)
            }
        })
    }

    const printVote = (comment, data, action) => {

        const votelike = `voteLike${comment}`
        const voteDisslike = `voteDisslike${comment}`
        const countDisslike = `countDisslike${comment}`

        const countLike = `countLike${comment}`

        const userVote = data.user_id
        const vote = data.vote

        if (action == 'likes') {
            console.log('like')
            if (vote.likes > 0) {
                document.querySelector(`#${votelike}`).classList.add('text-success')
                document.querySelector(`#${votelike}`).classList.remove('text-dark')
                document.querySelector(`#${voteDisslike}`).classList.remove('text-danger')
                document.querySelector(`#${voteDisslike}`).classList.add('text-dark')
                document.querySelector(`#${countLike}`).textContent = data.likeCount.likeCount
                document.querySelector(`#${countDisslike}`).textContent = data.disslikeCount.disslikeCount

            } else {
                document.querySelector(`#${votelike}`).classList.remove('text-success')
                document.querySelector(`#${countLike}`).textContent = data.likeCount.likeCount
            }
        } else {
            console.log('disslike')
            if (vote.disslikes > 0) {
                document.querySelector(`#${votelike}`).classList.remove('text-success')
                document.querySelector(`#${votelike}`).classList.add('text-dark')
                document.querySelector(`#${voteDisslike}`).classList.remove('text-dark')
                document.querySelector(`#${voteDisslike}`).classList.add('text-danger')
                document.querySelector(`#${countLike}`).textContent = data.likeCount.likeCount
                document.querySelector(`#${countDisslike}`).textContent = data.disslikeCount.disslikeCount

            } else {
                document.querySelector(`#${voteDisslike}`).classList.remove('text-danger')
                document.querySelector(`#${countDisslike}`).textContent = data.disslikeCount.disslikeCount
            }
        }

    }

    $(document).on('click', '.reply-comment', function (e) {
        e.preventDefault()
        let post = $(this).data('post')
        let comment = $(this).data('comment')
        let text = document.querySelector(`#comment_${comment}`).value
        $.ajax({
            method: 'post',
            url: "models/comments/insertComment.php",
            data: {
                post: post,
                comment: comment,
                text: text
            },
            dataType: 'json',
            success: function (data) {
                document.querySelector(`#comment_${comment}`).value = ""
                $(`#commentReply${comment}`).collapse('hide')
                getComments('comments_display')
            }, error: function (err) {
                console.log(err)
            }
        })
    })

    const printComments = (data, whereToPlace) => {
        console.log(`${whereToPlace}`)
        let ispis = ''
        data.comments.forEach(comment => {
            ispis += printComment(comment, data.user)
        })
        document.querySelector(`#${whereToPlace}`).innerHTML = ispis
    }

    const printComment = (comment, user) => {
        let ispis = ''
        let user_neg = user == null ? "disabled" : ''
        console.log(comment)
        let user_like = user != null && comment.user_reaction != false && comment.user_id == comment.user_reaction.user_id && comment.user_reaction.likes > 0 ? 'text-success' : 'text-dark'
        let user_disslike = user != null && comment.user_reaction != false && comment.user_id == comment.user_reaction.user_id && comment.user_reaction.disslikes > 0 ? 'text-danger' : 'text-dark'

        ispis += `
                <div class="card mb-1">
                <div class="card-header">
                    <div class="float-start">
                       `
        if (comment.parent_id > 0) {
            ispis += ` <h2 class="fs-6 mt-1">Reply @${comment.firstName + ' ' + comment.lastName}</h2>`
        } else {
            ispis += ` <h2 class="fs-6 mt-1">${comment.firstName + ' ' + comment.lastName}</h2>`
        }
        ispis += `
                    </div>
                    <div class="float-end">
                        <span class="text-muted">${prittierDateFormat(comment.created_at)}</span>
                    </div>
                </div>
                <div class="card-body">
                    <p class="card-text">${comment.text}</p>
                    <div class="gap-3 d-flex">
                        <button class="btn btn-transparent d-flex vote-action" id="like-${comment.id}" data-action="likes" data-post="${comment.post_id}" data-comment="${comment.id}" ${user_neg}>
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" id="voteLike${comment.id}" class="bi bi-hand-thumbs-up  ${user_like}" viewBox=" 0 0 16 16">
                                <path d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z" />
                            </svg>
                            <big class="ms-3 mt-1" id="countLike${comment.id}">${comment.likes.likesCount}</big>
                        </button>


                        <button class="btn btn-transparent d-flex vote-action"  id="disslike-${comment.id}" data-action="disslikes" data-post="${comment.post_id}" data-comment="${comment.id}" ${user_neg}>
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" id="voteDisslike${comment.id}" class="bi bi-hand-thumbs-up ${user_disslike}" viewBox="0 0 16 16">
                                <path d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z" />
                            </svg>
                            <big class="ms-3 mt-1" id="countDisslike${comment.id}">${comment.disslikes.disslikesCount}</big>
                        </button>
                    </div>
                </div>
                
                <div class="card-footer">
                <div class="float-end gap-2">`
        if (comment.countChild.childComments > 0) {
            ispis += `  <button class="btn btn-primary read-more" data-user="${user.id}" type="button" id="btnReadMore${comment.id}" data-bs-toggle="collapse" data-bs-target="#comment${comment.id}" aria-expanded="false" aria-controls="comment${comment.id}" data-comment="${comment.id}">
                                Show more
                    </button>`
        }
        if (user != null) {
            ispis += `  <button class=" btn btn-outline-primary comment-reply" data-post="${comment.id_post}" data-comment="${comment.id}" data-bs-toggle="collapse" data-bs-target="#commentReply${comment.id} " aria-expanded="false" aria-controls="commentReply${comment.id} ">Reply</button>`
        }


        ispis += `</div>
                    </div>
                    </div>
                  
                    
                    <div class="collapse my-2" id="comment${comment.id}">

                                </div>

                                <div class="collapse" id="commentReply${comment.id}">

                                </div>
                `
        return ispis
    }

    const prittierDateFormat = (datetime) => {
        const dateTime = datetime.split(' ')
        const time = dateTime[1]
        const date = dateTime[0].split('-')
        const finalDate = time + " " + date[2] + "/" + date[1] + "/" + date[0]
        return finalDate
    }
    $(document).on('click', '.comment-reply', function (e) {
        let comment = $(this).data('comment')
        let post = $(this).data('post')
        // commentReply8
        console.log(comment)
        console.log(document.querySelector(`#commentReply${comment}`))
        let ispis = '';
        ispis += `
          
                <div class="card card-body">
                    <textarea name="comment" id="comment_${comment}" cols="30" rows="5" class="form-control"></textarea>
                        <div class="row">
                            <div class="float-end col-3  mt-2">
                                <div class="d-grid"><button class="btn btn-primary reply-comment" type="button" id="btnCommentReply${comment}" data-post="${post}" data-comment="${comment}">Save</button></div>
                            </div>
                </div>
            
        `
        document.querySelector(`#commentReply${comment}`).innerHTML = ispis
    })
    const date = new Date()
    document.querySelector('#getYear').textContent = date.getFullYear()

    $(document).on('click', '#btnContactUs', function (e) {
        e.preventDefault()
        // alert('da')
        contactFormValidation()
    })

    const contactFormValidation = () => {
        console.log('radi')
        let first_name = document.querySelector('#firstName').value
        let last_name = document.querySelector('#lastName').value
        let email = document.querySelector('#email').value
        let message = document.querySelector('#message').value

        let errors = [];
        console.log(first_name)
        let reFirstLastName = /^[A-Z][a-z]{3,15}$/
        let reEmail = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/
        // let reMessage = /^$/
        if (!reFirstLastName.test(first_name)) {
            errors.push(first_name)
            createValidationErrorMessage('#contactFirstNameErrorMessage', 'text-danger', "First name isn't valid")
        } else {
            removeValidtionErrorMessage('#contactFirstNameErrorMessage', 'text-danger')
        }
        if (!reFirstLastName.test(last_name)) {
            errors.push(last_name)
            createValidationErrorMessage('#contactLastNameErrorMessage', 'text-danger', "Last name isn't vadlid")
        } else {
            removeValidtionErrorMessage('#contactLastNameErrorMessage', 'text-danger')
        }
        if (!reEmail.test(email)) {
            errors.push(email)
            createValidationErrorMessage('#contactEmailErrorMessage', 'text-danger', "Email isn't valid")
        } else {
            removeValidtionErrorMessage('#contactEmailErrorMessage', 'text-danger')
        }
        if (message.length == 0) {
            errors.push(message)
            createValidationErrorMessage('#contactMessageErrorMessage', 'text-danger', 'Message must not be empty')
        } else {
            removeValidtionErrorMessage('#contactMessageErrorMessage', 'text-danger')
        }
        if (errors.length == 0) {
            $.ajax({
                method: 'post',
                url: 'models/action/contact.php',
                data: {
                    firstName: first_name,
                    lastName: last_name,
                    email: email,
                    message: message
                }, dataType: 'json',
                success: function (data, statusTxt, xhr) {
                    console.log(data.user)
                    if (xhr.status == 201) {
                        printMessage('We contact you soon as we can', '#printContactMessage', 'success')
                        if (data.user != "") {
                            document.querySelector('#message').value = ""
                        } else {
                            document.querySelector('#message').value = ""
                            document.querySelector('#email').value = ""
                            document.querySelector('#firstName').value = ""
                            document.querySelector('#lastName').value = ""
                        }
                    }
                }, error: function (err) {
                    console.log(err)
                }
            })
        }
    }
    const createValidationErrorMessage = (element, classes, text) => {
        const el = document.querySelector(element)
        el.classList.add(classes)
        el.textContent = text
    }

    const removeValidtionErrorMessage = (element, classes) => {
        const el = document.querySelector(element)
        el.classList.remove(classes)
        el.textContent = ""
    }
    const printMessage = (message, whereToPlace, color) => {

        let ispis = ''
        ispis += `
            <div class="alert alert-${color} alert-dismissible fade show fw-bold" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `
        $(whereToPlace).html(ispis)
    }
})