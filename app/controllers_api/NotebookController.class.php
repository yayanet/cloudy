<?php

class NotebookController extends ApiController
{
    public function add()
    {
        if (empty($_REQUEST['name'])) {
            $this->invalid_request('name');
            return;
        }

        if (! $this->check_login()) return;
        
        $notebookId = NotebookModel::getInstance()->add($_REQUEST['name'], self::$userId);
        if (empty($notebookId)) {
            $response = array('error' => 'add_notebook_failed');
        }
        else {
            $notebook = NotebookModel::getInstance()->get($notebookId);
            $responseNotebook = ApiHelper::instance()->notebook_for_response($notebook);
            $response = array('notebook' => $responseNotebook);
        }

        $this->render($response);
    }

    public function remove()
    {
        if (empty($_REQUEST['notebook_id'])) {
            $this->invalid_request('notebook_id');
            return;
        }

        if (! $this->check_login()) return;

        // Check permission
        $notebookId = intval($_REQUEST['notebook_id']);
        $notebook = NotebookModel::getInstance()->get($notebookId);
        if (empty($notebook)) {
            $this->error('notebook_not_exists');
            return;
        }

        if ($notebook['user_id'] != self::$userId) {
            $this->permission_denied();
            return;
        }

        $success = NotebookModel::getInstance()->remove($notebookId);
        if ($success) {
            $response = array('result' => 'success');
        }
        else {
            $response = array('error' => 'remove_notebook_failed');
        }

        $this->render($response);
    }

    public function rename()
    {
        if (empty($_REQUEST['notebook_id']) OR empty($_REQUEST['name'])) {
            $this->invalid_request('notebook_id', 'name');
            return;
        }

        if (! $this->check_login()) return;

        // Check permission
        $notebookId = intval($_REQUEST['notebook_id']);
        $notebook = NotebookModel::getInstance()->get($notebookId);
        if (empty($notebook)) {
            $this->error('notebook_not_exists');
            return;
        }

        if ($notebook['user_id'] != self::$userId) {
            $this->permission_denied();
            return;
        }

        $success = NotebookModel::getInstance()->update_name($notebookId, $_REQUEST['name']);
        if ($success) {
            $notebook = NotebookModel::getInstance()->get($notebookId);
            $responseNotebook = ApiHelper::instance()->notebook_for_response($notebook);
            $response = array('notebook' => $responseNotebook);
        }
        else {
            $response = array('error' => 'rename_notebook_failed');
        }

        $this->render($response);
    }

    public function list_()
    {
        if (! $this->check_login()) return;

        $notebookList = NotebookModel::getInstance()->get_list_by_user_id(self::$userId);
        $responseList = ApiHelper::instance()->notebook_list_for_response($notebookList);
        $this->render(array('data' => $responseList));
    }
}
