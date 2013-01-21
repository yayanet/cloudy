<?php
class NoteController extends PController
{
    public function index()
    {
        $this->set_page_title('Note');
        $this->display();
    }
}