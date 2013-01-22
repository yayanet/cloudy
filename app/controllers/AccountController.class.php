<?php
class AccountController extends PController
{
    public function login()
    {
        if ($this->is_submit()) {
            $this->_handle_login();
            return;
        }
    }

    public function logout()
    {
        $this->_handle_logout();
    }

    public function register()
    {
        if ($this->is_submit()) {
            $this->_handle_register();
            return;
        }
    }


    ////////////////////////
    private function _handle_login()
    {
        $result = 'failed';
        $message = '';

        if (empty($_REQUEST['username']) || empty($_REQUEST['password'])) {
            $message = 'username/password cannot be empty';
        }
        else {
            // Check
            $user = UserModel::getInstance()->get_by_email_and_password($_REQUEST['username'], $_REQUEST['password']);
            if (empty($user)) {
                $message = 'your username or password is incorrect';
            }
            else {
                // Login
                $session = SessionModel::getInstance()->get_by_id(self::$sessionId);
                if (empty($session)) {
                    // Save session to db if does not exist
                    $success = SessionModel::getInstance()->add(self::$sessionId, 1, $user['user_id']);
                }
                else {
                    // Update user id
                    $success = SessionModel::getInstance()->update_user_id(self::$sessionId, $user['user_id']);
                }

                if ($success) {
                    $result = 'success';
                }
                else {
                    $message = 'unknown_error';
                }
            }
        }

        if ($this->is_ajax()) {
            echo json_encode(array(
                'result' => $result,
                'message' => $message
            ));
        }
        else {
            $this->assign('login_result', $result);
            $this->assign('message', $message);
            // TODO: display
            //$this->display();
        }
    }

    private function _handle_logout()
    {
        SessionModel::getInstance()->update_user_id(self::$sessionId, 0);

        if ($this->is_ajax()) {
            echo json_encode(array(
                'result' => 'success',
                'redirect' => '/'
            ));
        }
        else {
            header('Location: /');
        }
    }

    private function _handle_register()
    {
    }
}
