$(document).ready(function () {
    $('.btn-reply').click(function (e) {
        e.preventDefault()
        let data_id = $(this).data("id")
        console.log(data_id)
        // if ($(this).hasClass('d-none')) {
        //     console.log('izmena')
        // } else {
        //     console.log('povratak na prvobitno stanje')
        // }
        if ($(`#${data_id}`).hasClass('d-none')) {
            $(`#${data_id}`).addClass('d-block').removeClass('d-none');
            $(this).html('Cancel reply')
        } else {
            $(`#${data_id}`).removeClass('d-block').addClass('d-none');
            $(this).html('Reply')
        }
        // $(this).addClass('d-none')
        // $('.cancel-comment').data('comment_id', data_id)
    });
    $('.submitComment').click(function (e) {
        e.preventDefault();
        console.log('izmena')
        var textarea = $('.textarea-commnet').val()
        console.log(textarea)
    });

    $(document).on('click', '.comment-reply', function (e) {
        e.preventDefault();
        let comment_id = $(this).data('comment')
        let post_id = $(this).data('post')
        let text = $(`#reply_comment${comment_id}`).val()
        if (text != "") {
            $.ajax({
                method: 'post',
                url: 'models/comments/insert.php',
                data: {
                    comment_id: comment_id, post_id: post_id, text: text
                },
                dataType: 'json',
                success: function (response) { }
            })
        }
    });
    $(document).on('click', '.btn-view-more', function (e) {
        e.preventDefault();
        let post_id = $(this).data('post')
        let comment_id = $(this).data('comment')
        console.log(comment_id)
        $.ajax({
            method: 'get',
            url: 'models/comments/getComments.php',
            data: {
                post_id: post_id,
                comment_id: comment_id
            },
            dataType: 'json',
            success: function (response) {
                printChildComments(response)
            }
        })

    });
    $('.cancel-comments').click(function (e) {
        e.preventDefault()
        // alert("zatvaranje dijaloga")
        let data_id = $(this).data('id')
        console.log(data_id)
        let comment_id = $(this).data('comment_id')
        console.log(comment_id)
        // const id = $('.card-reply').attr('id')
        // console.log(id)
    })

    const printChildComments = (comments, whereToPlace) => {
        if (comments.length > 0) {
            comments.forEach(comment => {
                printComment(comment)
            })
        } else {
            console.log('nemamo commentar')
        }
    }
    const printComment = (comment) => {

    }

    $(document).on('click', '.btn-like', function (e) {
        e.preventDefault();
        let comment = $(this).data('comment')
        let post = $(this).data('post')
        $.ajax({
            type: "POST",
            url: "models/actions/vote.php",
            data: {
                comment: comment,
                post: post,
                action: "like"
            },
            dataType: "JSON",
            success: function (response) {
                console.log(response)
            }
        });
    });
    $(document).on('click', '.btn-disslike', function (e) {
        e.preventDefault()
        let comment = $(this).data('comment')
        let post = $(this).data('post')
        $.ajax({
            type: "POST",
            url: "models/actions/vote.php",
            data: { comment: comment, post: post, action: 'disslike' },
            dataType: "JSON",
            success: function (response) {

            }
        });
    })
});