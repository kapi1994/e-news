

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

        br++
        if (br % 2 != 0) {
            console.log(br)
            getComments(comment, post)

        }

    })

    function getComments(comment_id = 0, post) {
        // console.log(comment_id)
        $.ajax({
            method: "get",
            url: 'models/comments/getComments.php',
            data: { comment: comment_id, post: post },
            dataType: 'json',
            success: function (data) { },
            error: function (err) { }
        })
    }
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