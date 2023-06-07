<?php

class CommentModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function addComment($comment, $user_id, $post_id)
    {
        $data = array(
            'commentDescription' => $comment,
            'userID' => $user_id,
            'postID' => $post_id
        );
        $this->db->insert('comment', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getComment($id)
    {
        // $sql = 'SELECT * FROM users WHERE postID = ' . $id . '';
        $sql = 'SELECT comment.*, users.* FROM comment JOIN users ON comment.userID = users.userID WHERE comment.postID = ' . $id . '';
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

}