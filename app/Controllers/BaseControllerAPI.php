<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Libraries\Templater;
use App\Models\API\V1\Consultas;
use App\Models\InscripcionModel;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
class BaseControllerAPI extends ResourceController
{
    /**
     * Instance of the main Request object.
     *
     * @var IncomingRequest|CLIRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['Psg'];
    protected $templater = null;
    protected $consultas = null;
    protected $inscripcionModel = null;
    protected $db = null;

    function __construct()
    {
        $this->templater = new Templater(\Config\Services::request());
        $this->consultas = new Consultas();
        $this->inscripcionModel = new InscripcionModel();
        $this->db = \Config\Database::connect();
    }

    /**
     * Constructor.
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param LoggerInterface $logger
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        $x = $this->consultas->seleccionarTabla('administrativo.psg_sede', '*', array('url_sede' => BASEURL))->getRowArray();
        defined('IDSEDE') || define('IDSEDE', ($x['id_sede'] ?? ''));
        defined('SEDE') || define('SEDE', ($x['denominacion_sede'] ?? ''));

        //--------------------------------------------------------------------
        // Preload any models, libraries, etc, here.
        //--------------------------------------------------------------------
        // E.g.: $this->session = \Config\Services::session();
    }
}
