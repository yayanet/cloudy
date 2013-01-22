<?php
class NotebookController extends PController
{
    public function list_()
    {
        $notebookList = NotebookModel::getInstance()->get_list_by_user_id(self::$userId);

        $this->assign('notebook_list', $notebookList);
        $this->display('', FALSE);
    }
}
