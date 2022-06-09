<?php

namespace App\Libraries;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;

class Templater extends BaseController
{
    public $request = null;

    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }

    function view($content, $data = [], $base = "base")
    {
        if ($this->request->isAJAX()) {
            $ajax = view($content, $data);
            return css_tag($content) . $ajax . script_tag($content);
        } else {
            $data['cabecera'] = view('cabecera', $data);
            $data['contenido'] = view($content, $data);
            $data['pie'] = view('pie', $data);
            return view($base, $data);
        }
    }
}
