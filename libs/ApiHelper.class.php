<?php

class ApiHelper
{
    static private $sharedInstance = NULL;

    /**
     * @return ApiHelper
     */
    static function instance()
    {
        if (self::$sharedInstance == NULL) {
            self::$sharedInstance = new ApiHelper();
        }
        return self::$sharedInstance;
    }


    public function notebook_for_response($notebook)
    {
        if (empty($notebook)) return array();

        return array(
            'notebook_id' => $notebook['notebook_id'],
            'name' => $notebook['name'],
            );
    }

    public function notebook_list_for_response($notebookList)
    {
        if (empty($notebookList)) return array();

        $responseList = array();
        foreach ($notebookList as $key => $notebook) {
            $responseList[$key] = $this->notebook_for_response($notebook);
        }
        return $responseList;
    }
    
    public function note_for_response($note)
    {
        if (empty($note)) return array();
    
        return array(
                'note_id' => $note['note_id'],
                'notebook_id' => $note['notebook_id'],
                'content' => $note['content'],
                'update_time' => $note['update_time'],
                'version' => $note['version']
        );
    }
    
    public function note_list_for_response($noteList)
    {
        if (empty($noteList)) return array();
    
        $responseList = array();
        foreach ($noteList as $key => $note) {
            $responseList[$key] = $this->note_for_response($note);
        }
        return $responseList;
    }
    
    
}
