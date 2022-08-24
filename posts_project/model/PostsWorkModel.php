<?php
include 'model/Model.php';

class PostsWorkModel extends Model
{
    public function addNewPost($name, $comment)
    {
        $date = date('d.m.Y');
        $this->db->query("INSERT INTO posts (name, comment, created_at) VALUES ('$name', '$comment', '$date')");
        return mysqli_insert_id($this->db);
    }

    public function setRating($postId, $rating)
    {
        $postData = $this->getById($postId, 'posts');

        if (!$postData[0]['rating']) {
            return $this->db->query("UPDATE posts SET rating = '$rating' WHERE id = '$postId'");
        } else {
            $rating = ((float)$postData[0]['rating'] + (int)$rating) / 2;
            return $this->db->query("UPDATE posts SET rating = '$rating' WHERE id = '$postId'");
        }
    }

    public function getPositiveAndNegativePostsCount()
    {
        $negativePosts = $this->db->query("SELECT COUNT(*) FROM posts WHERE rating < 3")->fetch_all(MYSQLI_ASSOC);
        $positivePosts = $this->db->query("SELECT COUNT(*) FROM posts WHERE rating >= 4")->fetch_all(MYSQLI_ASSOC);

        return array('positivePostsCount' => $positivePosts, 'negativePostsCount' => $negativePosts);
    }
}