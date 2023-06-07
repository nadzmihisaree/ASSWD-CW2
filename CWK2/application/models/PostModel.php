<?php

class PostModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getPosts()
    {
        $sql = 'SELECT post.*, users.* FROM post JOIN users ON post.userID = users.userID ORDER BY createdTime DESC';
        $query = $this->db->query($sql);

        $sql1 = 'SELECT comment.*, users.* FROM comment JOIN users ON comment.userID = users.userID';
        $query1 = $this->db->query($sql1);

        $sql2 = 'SELECT tag.*, post_tag.* FROM tag JOIN post_tag ON tag.tagID = post_tag.tagID';
        $query2 = $this->db->query($sql2);
        $result2 = $query2->result_array();
        
        foreach ($query->result() as $row) {
            $postID = $row->postID;
            
            $hashtags = array();

            $row->comments = array();
            foreach ($query1->result() as $row1) {
                if ($row->postID == $row1->postID) {
                    array_push($row->comments, $row1);
                }
            }
            for ($i = 0; $i < count($query2->result_array()); $i++) {
                if ($result2[$i]['postID'] == $postID) {
                    $hashtags[] = '#' . $result2[$i]['tag'];
                }
            }
            $row->tag = $hashtags;
        }

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getPost($id)
    {
        $sql = 'SELECT post.*, users.* FROM post JOIN users ON post.userID = users.userID WHERE users.userID = ' . $id . ' ORDER BY createdTime DESC';
        $query = $this->db->query($sql);
        
        $sql1 = 'SELECT comment.*, users.* FROM comment JOIN users ON comment.userID = users.userID';
        $query1 = $this->db->query($sql1);

        $sql2 = 'SELECT tag.*, post_tag.* FROM tag JOIN post_tag ON tag.tagID = post_tag.tagID';
        $query2 = $this->db->query($sql2);
        $result2 = $query2->result_array();

        foreach ($query->result() as $row) {
            $postID = $row->postID;
            $hashtags = array();

            $row->comments = array();
            foreach ($query1->result() as $row1) {
                if ($row->postID == $row1->postID) {
                    array_push($row->comments, $row1);
                }
            }
            for ($i = 0; $i < count($query2->result_array()); $i++) {
                if ($result2[$i]['postID'] == $postID) {
                    $hashtags[] = '#' . $result2[$i]['tag'];
                }
            }
            $row->hashtags = $hashtags;
        }

        if ($query->num_rows() > 0) {
            // var_dump($query->result());
            return $query->result();
        } else {
            return false;
        }
    }

    public function getSearch($tag){
        $sql = " SELECT post.*, users.* FROM post JOIN users ON post.userID = users.userID 
        INNER JOIN post_tag ON post_tag.postID = post.postID 
        INNER JOIN tag ON tag.tagID = post_tag.tagID 
        WHERE tag.tag = '".$tag."' ORDER BY createdTime DESC";
        $query = $this->db->query($sql);
        
        $sql1 = 'SELECT comment.*, users.* FROM comment JOIN users ON comment.userID = users.userID';
        $query1 = $this->db->query($sql1);

        $sql2 = 'SELECT tag.*, post_tag.* FROM tag JOIN post_tag ON tag.tagID = post_tag.tagID';
        $query2 = $this->db->query($sql2);
        $result2 = $query2->result_array();

        foreach ($query->result() as $row) {
            $postID = $row->postID;
            $hashtags = array();

            $row->comments = array();
            foreach ($query1->result() as $row1) {
                if ($row->postID == $row1->postID) {
                    array_push($row->comments, $row1);
                }
            }
            for ($i = 0; $i < count($query2->result_array()); $i++) {
                if ($result2[$i]['postID'] == $postID) {
                    $hashtags[] = '#' . $result2[$i]['tag'];
                }
            }
            $row->hashtags = $hashtags;

        }

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function createPost($image, $caption, $user_id)
    {
        $data = array(
            'image' => $image,
            'caption' => $caption,
            'userID' => $user_id
        );
        $this->db->insert('post', $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function deletePost($id)
    {
        
        $this->db->where('postID', $id);
        $this->db->delete('comment');
        
        $this->db->where('postID', $id);
        $this->db->delete('post');
        
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

}