<?php
// user interface
interface user
{
    public function login($user,$pass);
    public function logout();
	public function createNew($user,$pass);
	public function authenticate();
}

?>