<?php
require 'model/PostsWorkModel.php';
require 'model/CommentsWorkModel.php';

if ($_GET['type'] == 'addPost' && strlen($_REQUEST['name']) > 2 && strlen($_REQUEST['comment']) > 3) {

    $post_model = new PostsWorkModel('localhost', 'root', '', 'posts_work');
    $postId = $post_model->addNewPost($_REQUEST['name'], $_REQUEST['comment']);

} elseif ($_GET['type'] == 'addPostComment' && strlen($_REQUEST['name']) > 2 && strlen($_REQUEST['comment']) > 3) {

    $comment_model = new CommentsWorkModel('localhost', 'root', '', 'posts_work');
    $comment_model->addNewPostComment($_REQUEST['name'], $_REQUEST['comment'], $_REQUEST['postId']);

} elseif ($_GET['type'] == 'setRating' && $_REQUEST['postId'] && $_REQUEST['rating']) {

    session_start();
    $post_model = new PostsWorkModel('localhost', 'root', '', 'posts_work');
    $post_model->setRating($_REQUEST['postId'], $_REQUEST['rating']);
    $_SESSION['rating'][$_REQUEST['postId']] = $_REQUEST['rating'];
    echo json_encode(['rating' => round($post_model->getById($_REQUEST['postId'], 'posts')[0]['rating'], 1)]);

} elseif ($_GET['type'] == 'getPostsCounter') {

    $post_model = new PostsWorkModel('localhost', 'root', '', 'posts_work');
    $postsCountData = array('all_count' => $post_model->count('posts')[0]);
    echo json_encode($postsCountData);

} elseif ($_GET['type'] == 'getCommentsCounter') {

    $comment_model = new CommentsWorkModel('localhost', 'root', '', 'posts_work');
    echo $comment_model->countCommentsByPostId($_REQUEST['postId'])[0];

} elseif ($_GET['type'] == 'refreshRatingPostsCounter') {

    $post_model = new PostsWorkModel('localhost', 'root', '', 'posts_work');
    $postRatingCountData = $post_model->getPositiveAndNegativePostsCount();
    echo json_encode(array('positiveCounter' => $postRatingCountData['positivePostsCount'][0]['COUNT(*)'], 'negativeCounter' => $postRatingCountData['negativePostsCount'][0]['COUNT(*)']));
}
?>

<? if ($_GET['type'] == 'addPost' && strlen($_REQUEST['name']) > 2 && strlen($_REQUEST['comment']) > 3): ?>
    <div class="card">
        <div class="card-body">
            <h6 class="card-subtitle mb-2 text-muted"><i>by</i> <?= $_REQUEST['name'] ?></h6>
            <div class="rating-area area-<?= $postId ?>">
                <p style="text-align: center">Ваша оцінка</p>
                <input type="radio" id="star-5-<?= $postId ?>" onclick="setPostRaiting(this.value, '<?= $postId ?>')"
                       name="rating-<?= $postId ?>" value="5">
                <label for="star-5-<?= $postId ?>" title=""></label>
                <input type="radio" id="star-4-<?= $postId ?>" onclick="setPostRaiting(this.value, '<?= $postId ?>')"
                       name="rating-<?= $postId ?>" value="4">
                <label for="star-4-<?= $postId ?>" title="Оценка «4»"></label>
                <input type="radio" id="star-3-<?= $postId ?>" onclick="setPostRaiting(this.value, '<?= $postId ?>')"
                       name="rating-<?= $postId ?>" value="3">
                <label for="star-3-<?= $postId ?>" title="Оценка «3»"></label>
                <input type="radio" id="star-2-<?= $postId ?>" onclick="setPostRaiting(this.value, '<?= $postId ?>')"
                       name="rating-<?= $postId ?>" value="2">
                <label for="star-2-<?= $postId ?>" title="Оценка «2»"></label>
                <input type="radio" id="star-1-<?= $postId ?>" onclick="setPostRaiting(this.value, '<?= $postId ?>')"
                       name="rating-<?= $postId ?>" value="1">
                <label for="star-1-<?= $postId ?>" title="Оценка «1»"></label>
            </div>
            <p style="text-align: center">Середній
                рейтинг(<span class="middle-rating-<?=$postId?>"><?= round($post_model->getById($postId, 'posts')[0]['rating'], 1) ?></span>)</p>
            <h6 class="card-subtitle mb-2 text-muted"><?= date('d.m.Y') ?></h6>
            <p class="card-text"><?= $_REQUEST['comment'] ?></p>
        </div>
        <div class="comment-<?= $postId ?>">
            <h6 style="text-align: center" class="card-subtitle mb-2 text-muted">Comments <span class="comments-counter-<?=$postId?>">0</span></h6>
        </div>
        <button type="button" id="add-comment-btn" class="btn btn-outline-success" data-toggle="modal"
                data-target="#add-comment-modal" onclick="comentingPost('<?= $postId ?>')">Add Comment
        </button>
    </div>
<? endif; ?>

<? if ($_GET['type'] == 'addPostComment'): ?>
    <div class="card-body">
        <h6 class="card-subtitle mb-2 text-muted"><?= $_REQUEST['name'] ?></h6>
        <h6 class="card-subtitle mb-2 text-muted"><?= date('d.m.Y') ?></h6>
        <p class="card-text"><?= $_REQUEST['comment'] ?></p>
    </div>
<? endif; ?>