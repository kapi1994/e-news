$(document).ready(function () {
    $(document).on('click', '#btnSubmit', function (e) {
        e.preventDefault();
        let text = document.querySelector('.textarea-commnet').value
        let post_id = $(this).data('post')
        $.ajax({
            method: "POST",
            url: "models/comments/insert.php",
            data: { text: text, post_id: post_id },
            dataType: 'json',
            success: function () {
                getComments(post_id)
                document.querySelector('.textarea-commnet').value = " "
            },
            error: function (jqXHR, statusTxt, xhr) { }
        })
    })

    const getComments = (post_id) => {
        $.ajax({
            method: "get",
            url: "models/comments/getComments.php",
            dataType: 'json',
            data: { id: post_id },
            success: function (data) {
                printComments(data)

            }
        })
    }

    const printComments = (comments) => {
        let ispis = ''
        if (comments.length == 1) {
            ispis += printComment(comments)
        } else {
            comments.forEach(comment => {
                console.log(comment)
                ispis += printComment(comment)
            })
        }
        $('#comments').html(ispis)
    }

    const printComment = (comment) => {
        console.log(comment)
        return `
        <div class="card mb-1">
            <div class="card-header">
                <em class="float-start fts-italic text-uppercase">${comment.firstName + ' ' + comment.lastName}</em>
                <em class="float-end fts-italic text-uppercase text-muted fw-bold">${comment.created_at}</em>
            </div>
            <div class="card-body">
                <p class="fts-italic">${comment.text}</p>
            </div>
        </div>
        `
    }
});