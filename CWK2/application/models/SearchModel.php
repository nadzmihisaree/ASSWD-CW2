<?php

class SearchModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    //save hashtags
    public function insertTags($hashtags, $postID)
    {
        $hashtagsSplitted = !empty($hashtags) ? preg_split('/#/', $hashtags): array();
        $tags = array_filter($hashtagsSplitted);    
        $hashtagSave = array_map('trim', $tags);
        
        foreach($hashtagSave as $tag) {
            $data = array(
                'tag' => $tag,
            );
            $this->db->insert('tag', $data);

            $data_map = array(
                'tagID' => $this->db->insert_id(),
                'postID' => $postID,        
            );
            $this->db->insert('post_tag', $data_map);
        }
    }

}