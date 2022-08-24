<?php

class CommentsWorkModel extends Model
{
    public function addNewPostComment($name, $comment, $postId)
    {
        $date = date('d.m.Y');
        return $this->db->query("INSERT INTO comments (name, comment, created_at, post_id) VALUES ('$name', '$comment', '$date', '$postId')");
    }

    public function getCommentsByPostId($postId)
    {
        return $this->db->query("SELECT * FROM comments WHERE post_id='$postId'")->fetch_all(MYSQLI_ASSOC);
    }

    public function countCommentsByPostId($postId)
    {
        return $this->db->query("SELECT COUNT(*) FROM comments WHERE post_id='$postId'")->fetch_row();
    }
}