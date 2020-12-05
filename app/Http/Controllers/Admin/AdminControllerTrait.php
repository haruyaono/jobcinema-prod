<?php

namespace App\Http\Controllers\Admin;

trait AdminControllerTrait
{
    protected $title;
    protected $header;
    protected $description;
    protected $headericon;

    protected function setPageInfo($title = null, $header = null, $description = null, $headericon = null)
    {
        if (isset($header)) {
            $this->header = $header;
        }
        if (isset($description)) {
            $this->description = $description;
        }
        if (isset($title)) {
            $this->title = $title;
        }
        if (isset($headericon)) {
            $this->headericon = $headericon;
        }
    }
}
