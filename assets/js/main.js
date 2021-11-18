

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
            success: function () {

                getComments('comments_display')
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
        console.log(comment + ' linija iz read more')
        br++
        if (br % 2 != 0) {
            document.querySelector(`#btnReadMore${comment}`).textContent = "show less"

        } else {
            document.querySelector(`#btnReadMore${comment}`).textContent = "show more"
        }
        getComments(comment, whereToPlace)



    })

    function getComments(whereToPlace, comment_id = 0) {
        const comment = comment_id == 0 ? 0 : comment_id
        const post = window.location.href.split("&")[1].split("=")[1]
        $.ajax({
            method: "get",
            url: 'models/comments/getComments.php',
            data: { comment: comment_id, post: post },
            dataType: 'json',
            success: function (data) {
                console.log(data)
                printComments(data.comments, data.user, whereToPlace)
            },
            error: function (err) { }
        })
    }
    $(document).on('click', '.vote-action', function (e) {
        e.preventDefault();
        let post = $(this).data('post')
        let comment = $(this).data('comment')
        let action = $(this).data("action")
        // console.log(action)
        let like = $(this).data('like')
        let disslike = $(this).data('disslike')
        // console.log(comment)
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
        // console.log(action)
        $.ajax({
            method: 'get',
            url: "models/comments/getVote.php",
            data: {
                comment_id: comment,
                action: action
            },
            dataType: 'json',
            success: function (data) {
                // console.log(data)
                printVote(comment, data, action)
            },
            error: function (err) {
                console.log(err)
            }
        })
    }

    const printVote = (comment, data, action) => {
        // console.log(data)
        const votelike = `voteLike${comment}`
        const voteDisslike = `voteDisslike${comment}`
        const countDisslike = `countDisslike${comment}`
        // console.log(`Disslike za commentar ${voteDisslike}` + document.querySelector(`#${voteDisslike}`))
        // console.log(`Lajk za kometar ${votelike}` + document.querySelector(`#${votelike}`))
        const countLike = `countLike${comment}`
        // console.log(countLike)
        const userVote = data.user_id
        const vote = data.vote
        console.log(data.likeCount + " " + countLike)
        // // console.log(action)
        // // console.log(vote)
        console.log(data)
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
    const addClass = (element, classes) => {
        // console.log(element)
        const el = document.querySelector(`#${element}`)
        el.classList.add(classes)
    }
    const removeClass = (element, classes) => {
        const el = document.querySelector(`#${element}`)
        el.classList.remove(classes)
    }

    const increseVoteCount = (el, data) => {
        let element = document.querySelector(`#${el}`)
        element.textContent++

    }
    const removeVoteCount = (el, data) => {
        const element = document.querySelector(`#${el}`)
        if (element.textContent > 0) {
            element.textContent--
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
                console.log(data)
                // console(data.comments)
                // console.log(data.user)
            }, error: function (err) {
                console.log(err)
            }
        })
    })

    const printComments = (comments, user, whereToPlace) => {
        console.log(whereToPlace)
        ispis = ''
        if (comments.length > 0) {
            comments.forEach(comment => {
                ispis += printComment(comment, user)
            })
        }
        // console.log(ispis)
        $(`#${whereToPlace}`).html(ispis)
    }

    const printComment = (comment, user) => {
        let ispis = ''
        let user_neg = user == '' ? "disabled" : ''
        // console.log(comment)
        // $comment->disslikes->UserId
        let user_like_yes = user != '' && user.id == comment.likes.userId ? 'text-success' : 'text-dark'
        let user_disslike_yes = user != '' && user.id == comment.likes.userId ? 'text-danger' : 'text-dark'
        let user_like = user != null && comment.user_reaction != FALSE && user_id == comment.user_reaction.user_id && comment.user_reaction.likes > 0 ? 'text-success' : 'text-dark'
        let user_disslike = user != null && comment.user_reaction != FALSE && user_id == comment.user_reaction.user_id && comment.user_reaction.disslikes > 0 ? 'text-danger' : 'text-dark'
        ispis += `
            <div >
                <div class="card mb-1">
                <div class="card-header">
                    <div class="float-start">
                        <h2 class="fs-6 mt-1">${comment.firstName + ' ' + comment.lastName}</h2>
                    </div>
                    <div class="float-end">
                        <span class="text-muted">${prittierDateFormat(comment.created_at)}</span>
                    </div>
                </div>
                <div class="card-body">
                    <p class="card-text">${comment.text}</p>
                    <div class="gap-3 d-flex">`
        ispis += `<button class="btn btn-transparent d-flex vote-action" data-like="${comment.likes.likes != null ? comment.likes.likes : 0}" data-disslike="${comment.disslikes.disslikes != null ? comment.disslikes.disslikes : 0}" id="like-${comment.id}" data-action="likes" data-post="${comment.post_id}" data-comment="${comment.id}" ${user == null ? disabled : ''}>
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" id="voteLike${comment.id}" class="bi bi-hand-thumbs-up ${user_like} " viewBox=" 0 0 16 16">
                                    <path d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z" />
                            </svg>
                        <big class="ms-3 mt-1" id="countLike${comment.id}>${comment.likes.likesCount}</big>
                     </button>


                     <button class="btn btn-transparent d-flex vote-action" data-like="${comment.likes.likes != null ? comment.likes.likes : 0}" data-disslike="${comment.disslikes.disslikes != null ? comment.disslikes.disslikes : 0}" id="disslike-<?= $comment->id ?>" data-action="disslikes" data-post="<?= $post->id ?>" data-comment="<?= $comment->id ?>" <?php if (!isset($_SESSION['user'])) : ?> disabled<?php endif; ?>>
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" id="voteDisslike${comment.id}" class="bi bi-hand-thumbs-up ${user_disslike}" viewBox="0 0 16 16">
                                <path d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z" />
                            </svg>
                        <big class="ms-3 mt-1" id="countDisslike${comment.id}">${comment.disslikes.disslikeCount}</big>
                    </button>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="float-end gap-2">

                            <button class="btn btn-primary read-more" type="button" data-bs-toggle="collapse" data-bs-target="#comment${comment.id}" aria-expanded="false" aria-controls="comment${comment.id}" data-comment="${comment.id}">
                                Show more
                            </button>`
        if (user != '') {
            ispis += `   <button class=" btn btn-outline-primary" data-post="${comment.post_id}" data-comment="${comment.id}" data-bs-toggle="collapse" data-bs-target="#commentReply${comment.id}" aria-expanded="false" aria-controls="commentReply${comment.id}">Reply</button>`
        }

        //                     <button class=" btn btn-outline-primary" data-post="${comment.post_id}" data-comment="${comment.id}" data-bs-toggle="collapse" data-bs-target="#commentReply${comment.id}" aria-expanded="false" aria-controls="commentReply${comment.id}">Reply</button>

        ispis += `         </div >
                </div >

            </div >
        </div >
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
})