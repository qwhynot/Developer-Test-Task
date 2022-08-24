<!--add comment form-->
<div class="modal fade" id="add-comment-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Your comment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <input type="hidden" id="comment_post_id">
            <div class="modal-body">
                <form>
                    <div class="alert alert-danger" id="add-comment-err" style="display: none" role="alert">
                        Заповніть усі поля!
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label"><span
                                style="color: red">*</span>Name:</label>
                        <input type="text" class="form-control" id="user_comentator_name">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label"><span
                                style="color: red">*</span>Comment:</label>
                        <textarea class="form-control" id="post_comentator_comment"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="close_add_post_comment_form" data-dismiss="modal">Close
                </button>
                <button type="button" class="btn btn-primary" onclick="addNewPostComment()">Add new comment</button>
            </div>
        </div>
    </div>
</div>