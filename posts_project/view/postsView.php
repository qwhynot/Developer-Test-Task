<?php
include 'model/PostsWorkModel.php';
include 'model/CommentsWorkModel.php';
include 'includes/postsView/addPostForm.php';
include 'includes/postsView/addCommentForm.php';

$postsModel = new PostsWorkModel('localhost', 'root', '', 'posts_work');
$commentsModel = new CommentsWorkModel('localhost', 'root', '', 'posts_work');

$postRatingCountData = $postsModel->getPositiveAndNegativePostsCount();

$posts = $postsModel->getAllFromTable('posts');
$postCount = $postsModel->count('posts');
?>

<div id="post-info">
    <div class="alert alert-success d-flex" role="alert">
        <div>
            <span class="negative-posts-counter"><?= $postRatingCountData['negativePostsCount'][0]['COUNT(*)'] ?></span><br>
            Negative posts
        </div>
    </div>
    <div class="alert alert-success d-flex" role="alert">
        <div>
            <span id="posts-counter"><?= $postCount[0] ?></span><br>
            All posts
        </div>
    </div>
    <div class="alert alert-success d-flex" role="alert">
        <div>
            <span class="positive-posts-counter"><?= $postRatingCountData['positivePostsCount'][0]['COUNT(*)'] ?></span><br>
            Positive posts
        </div>
    </div>
</div>

<div id="posts-container">
    <div class="add-new-post-btn-container">
        <button type="button" id="add-new-post-btn" data-toggle="modal"
                data-target="#exampleModal" class="btn btn-outline-success">Add New Post
        </button>
    </div>
    <? foreach ($posts as $post): ?>
        <div class="card">
            <div class="card-body">
                <h6 class="card-subtitle mb-2 text-muted"><i>by</i> <?= $post['name'] ?></h6>
                <div class="rating-area area-<?= $post['id'] ?>" <?= (isset($_SESSION['rating'][$post['id']])) ? 'style="pointer-events: none;"' : '' ?>>
                    <p style="text-align: center">Ваша оцінка</p>
                    <? if (isset($_SESSION['rating'][$post['id']])): ?>
                        <? for ($i = 5; $i >= 1; $i--): ?>
                            <input type="radio" id="star-<?= $i ?>-<?= $post['id'] ?> "
                                   onclick="setPostRaiting(this.value, '<?= $post['id'] ?>')"
                                   name="rating-<?= $post['id'] ?>" value="<?= $i ?>">
                            <label <?= ($i <= $_SESSION['rating'][$post['id']]) ? 'class="active"' : '' ?>
                                    for="star-<?= $i ?>-<?= $post['id'] ?>" title=""></label>
                        <? endfor; ?>
                    <? else: ?>
                        <input type="radio" id="star-5-<?= $post['id'] ?>"
                               onclick="setPostRaiting(this.value, '<?= $post['id'] ?>')"
                               name="rating-<?= $post['id'] ?>" value="5">
                        <label for="star-5-<?= $post['id'] ?>" title=""></label>
                        <input type="radio" id="star-4-<?= $post['id'] ?>"
                               onclick="setPostRaiting(this.value, '<?= $post['id'] ?>')"
                               name="rating-<?= $post['id'] ?>" value="4">
                        <label for="star-4-<?= $post['id'] ?>" title="Оценка «4»"></label>
                        <input type="radio" id="star-3-<?= $post['id'] ?>"
                               onclick="setPostRaiting(this.value, '<?= $post['id'] ?>')"
                               name="rating-<?= $post['id'] ?>" value="3">
                        <label for="star-3-<?= $post['id'] ?>" title="Оценка «3»"></label>
                        <input type="radio" id="star-2-<?= $post['id'] ?>"
                               onclick="setPostRaiting(this.value, '<?= $post['id'] ?>')"
                               name="rating-<?= $post['id'] ?>" value="2">
                        <label for="star-2-<?= $post['id'] ?>" title="Оценка «2»"></label>
                        <input type="radio" id="star-1-<?= $post['id'] ?>"
                               onclick="setPostRaiting(this.value, '<?= $post['id'] ?>')"
                               name="rating-<?= $post['id'] ?>" value="1">
                        <label for="star-1-<?= $post['id'] ?>" title="Оценка «1»"></label>
                    <? endif; ?>
                </div>
                <p style="text-align: center">Середній
                    рейтинг(<span class="middle-rating-<?=$post['id']?>"><?= round($postsModel->getById($post['id'], 'posts')[0]['rating'], 1) ?></span>)</p>
                <h6 class="card-subtitle mb-2 text-muted"><?= $post['created_at'] ?></h6>
                <p class="card-text"><?= $post['comment'] ?></p>
            </div>
            <div class="comment-<?= $post['id'] ?>">
                <h6 style="text-align: center" class="card-subtitle mb-2 text-muted">
                    Comments <span class="comments-counter-<?= $post['id'] ?>"><?= $commentsModel->countCommentsByPostId($post['id'])[0] ?></span></h6>
                <? foreach ($commentsModel->getCommentsByPostId($post['id']) as $comment): ?>
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted"><?= $comment['name'] ?></h6>
                        <h6 class="card-subtitle mb-2 text-muted"><?= $comment['created_at'] ?></h6>
                        <p class="card-text"><?= $comment['comment'] ?></p>
                    </div>
                <? endforeach; ?>
            </div>
            <button type="button" id="add-comment-btn" class="btn btn-outline-success" data-toggle="modal"
                    data-target="#add-comment-modal" onclick="comentingPost('<?= $post['id'] ?>')">Add Comment
            </button>
        </div>
    <? endforeach; ?>
</div>
<script src="/view/js/posts.js"></script>