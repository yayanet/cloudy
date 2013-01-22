<?php
class NoteController extends PController
{
    public function index()
    {
        $this->set_page_title('Note');
        $this->display();
    }

    public function list_()
    {
        if (empty($_REQUEST['notebook_id'])) {
            $noteList = NoteModel::getInstance()->get_list_by_user_id(self::$userId);
        }
        else {
            $notebookId = intval($_REQUEST['notebook_id']);
            $noteList = NoteModel::getInstance()->get_list_by_notebook_id($notebookId);
        }

        $this->assign('note_list', $noteList);
        $this->display('', FALSE);
    }
}
