<?php

class SessionsController extends MainController {

  public function prepare()
  {
    // TODO: $this->render('login.html');
		readfile(VIEWS . 'login.html');
  }

  public function create()
  {
    echo 'create!';
  }

  public function destroy()
  {
  }

}
