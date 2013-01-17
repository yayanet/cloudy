<?php

class NoteController extends ApiController
{
    public function add()
    {
        if (! $this->check_parameters('content')) return;
        
        if (! $this->check_login()) return;
        
        $notebookId = 0;
        if (isset($_REQUEST['notebook_id'])) {
            $notebookId = intval($_REQUEST['notebook_id']);
        }
        
        $noteId = NoteModel::getInstance()->add($notebookId, self::$userId, $_REQUEST['content']);
        if (empty($noteId)) {
            $response = array('error' => 'add_note_failed');
        }
        else {
            $note = NoteModel::getInstance()->get($noteId);
            $responseNote = ApiHelper::instance()->note_for_response($note);
            $response = array('note' => $note);
        }

        $this->render($response);
    }

    public function remove()
    {
        if (! $this->check_parameters('note_id')) return;

        if (! $this->check_login()) return;

        // Check permission
        $noteId = intval($_REQUEST['note_id']);
        if (! $this->_check_permission_for_note($noteId)) return;

        $success = NoteModel::getInstance()->remove($noteId);
        if ($success) {
            $response = array('result' => 'success');
        }
        else {
            $response = array('error' => 'remove_note_failed');
        }

        $this->render($response);
    }

    public function update()
    {
        if (! $this->check_parameters('note_id', 'content')) return;

        if (! $this->check_login()) return;

        // Check permission
        $noteId = intval($_REQUEST['note_id']);
        if (! $this->_check_permission_for_note($noteId)) return;
        
        $note = NoteModel::getInstance()->get($noteId);
        if ($note['content'] == $_REQUEST['content']) {
            $this->error('note_content_has_note_changed');
            return;
        }

        $success = NoteModel::getInstance()->update_content($noteId, $_REQUEST['content']);
        if ($success) {
            $note = NoteModel::getInstance()->get($noteId);
            $responseNote = ApiHelper::instance()->note_for_response($note);
            $response = array('note' => $responseNote);
        }
        else {
            $response = array('error' => 'update_note_failed');
        }

        $this->render($response);
    }

    public function list_()
    {
        if (! $this->check_login()) return;
        
        $notebookId = 0;
        if (isset($_REQUEST['notebook_id'])) {
            $notebookId = intval($_REQUEST['notebook_id']);
        }
        
        if ($notebookId == 0) {
            $noteList = NoteModel::getInstance()->get_list_by_user_id(self::$userId);
        }
        else {
            $noteList = NoteModel::getInstance()->get_list_by_notebook_id($notebookId);            
        }
        
        $responseList = ApiHelper::instance()->note_list_for_response($noteList);
        $this->render(array('data' => $responseList));
    }
    
    
    ////////////////////////////////////////////////////////////////////
    
    private function _check_permission_for_note($noteId)
    {
        $note = NoteModel::getInstance()->get($noteId);
        if (empty($note)) {
            $this->error('note_not_exists');
            return FALSE;
        }
        
        $notebook = NotebookModel::getInstance()->get($note['notebook_id']);
        if (empty($notebook)) {
            $this->error('notebook_not_exists');
            return FALSE;
        }
        
        if ($notebook['user_id'] != self::$userId) {
            $this->permission_denied();
            return FALSE;
        }
        
        return TRUE;
    }
}
