<?php

class ApiHelper
{
    static private $sharedInstance = NULL;

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
}
