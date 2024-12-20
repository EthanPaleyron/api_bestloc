<?php
namespace App\Controller;
use App\Renderer\JsonRenderer;
use BestLoc\Service\CustomerService;
use BestLoc\Entity\Customer;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CustomerController
{
    private CustomerService $customer;
    private JsonRenderer $renderer;
    public function __construct()
    {
        $this->customer = new CustomerService();
        $this->renderer = new JsonRenderer();
    }
    public function getById(Request $req, Response $res, $args): Response
    {
        $id = $args['id'];

        if (!isset($id)) {
            return $this->renderer->json($res, ["error" => "no email specified"], [], 404);
        }

        $customer = $this->customer->find($id);

        // if (!$customer instanceof Customer) {
        //     return $this->renderer->json($res, ["error" => "Internal Server Error"], [], 500);
        // }

        var_dump($customer);

        return $this->renderer->json($res, $customer);
    }
    public function getAll(Request $req, Response $res, $args): Response
    {
        $customer = $this->customer->findAll();
        return $this->renderer->json($res, $customer);
    }
}