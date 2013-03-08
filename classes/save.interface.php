<?php
// Form Tools - save.interface.php

interface save
{
    public function write($what,$where);
    public function read($fromWhere);
	public function delete($what);
}
?>