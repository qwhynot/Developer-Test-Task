function addNewPost() {
    let userName = document.getElementById('user_name').value;
    let userComment = document.getElementById('post_comment').value;

    if (userName.length > 2 && userComment.length > 3) {
        $.ajax({
            type: 'POST',
            url: '/ajax.php?type=addPost',
            data: {'name': userName, 'comment': userComment},
            success: function (response) {
                document.getElementById('posts-container').innerHTML += response;
                document.getElementById('add-post-err').style.display = 'none';
                document.getElementById('close_add_post_form').click();
                refreshPostsCounter();
            }
        })
    } else {
        document.getElementById('add-post-err').style.display = 'block';
    }
}

function comentingPost(postId) {
    let comment_post_id = document.getElementById('comment_post_id');

    comment_post_id.value = postId;
}

function addNewPostComment() {
    let postId = document.getElementById('comment_post_id').value;
    let name = document.getElementById('user_comentator_name');
    let comment = document.getElementById('post_comentator_comment');

    if (name.value.length > 2 && comment.value.length > 3) {
        $.ajax({
            type: 'POST',
            url: '/ajax.php?type=addPostComment',
            data: {'postId': postId, 'name': name.value, 'comment': comment.value},
            success: function (response) {
                document.getElementsByClassName('comment-' + postId)[0].innerHTML += response;
                document.getElementById('add-comment-err').style.display = 'none';
                document.getElementById('close_add_post_comment_form').click();
                refreshCommentsCounter(postId);
            }
        })
    } else {
        document.getElementById('add-comment-err').style.display = 'block';
    }
}

function setPostRaiting(rating, postId) {
    if (rating && postId) {
        let ratingContainer = document.querySelector('.area-' + postId);

        $.ajax({
            type: 'POST',
            url: '/ajax.php?type=setRating',
            data: {'postId': postId, 'rating': rating},
            success: function (response) {
                response = JSON.parse(response);

                document.getElementsByClassName('middle-rating-' + postId)[0].innerHTML = response.rating;
                ratingContainer.style.pointerEvents = 'none';
                refreshRatingPostsCounter();
                let ratingStars = document.querySelectorAll('.area-' + postId + ' label')

                for (let star = 4; star >= 5 - +rating; star--) {
                    ratingStars[star].classList.add('active')
                }
            }
        })
    }
}

function refreshPostsCounter() {
    $.ajax({
        type: 'POST',
        url: '/ajax.php?type=getPostsCounter',
        success: function (response) {
            response = JSON.parse(response);
            document.getElementById('posts-counter').innerHTML = response.all_count;
        }
    })
}

function refreshCommentsCounter(postId) {
    $.ajax({
        type: 'POST',
        url: '/ajax.php?type=getCommentsCounter',
        data: {'postId': postId},
        success: function (response) {
            document.getElementsByClassName('comments-counter-' + postId)[0].innerHTML = response;
        }
    })
}

function refreshRatingPostsCounter() {
    $.ajax({
        type: 'POST',
        url: '/ajax.php?type=refreshRatingPostsCounter',
        success: function (response) {
            console.log(response)
            response = JSON.parse(response);

            document.getElementsByClassName('negative-posts-counter')[0].innerHTML = response.negativeCounter;
            document.getElementsByClassName('positive-posts-counter')[0].innerHTML = response.positiveCounter;
        }
    })
}