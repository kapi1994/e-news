

$(document).ready(function () {
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
                console.log(success)
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
        $.ajax({
            method: 'get',
            url: 'models/comments/getComments.php',
            data: {
                post: post,
                comment: comment
            }, dataType: "json",
            success: function (data) { },
            error: function (err) { }
        })
    })

    $(document).on('click', '.vote-action', function (e) {
        e.preventDefault();
        let post = $(this).data('post')
        let comment = $(this).data('comment')
        let action = $(this).data("action")
        console.log(comment)
        $.ajax({
            method: "POST",
            url: "models/comments/vote.php",
            data: {
                post: post,
                comment: comment,
                action: action
            }, dataType: "json",
            success: function (data) { },
            error: function (err) { }
        })
    })
})