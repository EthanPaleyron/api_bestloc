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
            return $this->renderer->json($res, ["error" => "No id specified"], [], 404);
        }

        $customer = $this->customer->find($id);

        if (!$customer instanceof Customer) {
            return $this->renderer->json($res, ["error" => "Customer not found"], [], 404);
        }

        return $this->renderer->json($res, $customer);
    }

    public function getAll(Request $req, Response $res, $args): Response
    {
        $customer = $this->customer->findAll();
        return $this->renderer->json($res, $customer);
    }

    public function create(Request $req, Response $res): Response
    {
        $data = $req->getParsedBody();

        if (!$data) {
            return $this->renderer->json($res, ["error" => "Invalid input data"], [], 400);
        }

        $newCustomer = $this->customer->create($data);

        if (!$newCustomer instanceof Customer) {
            return $this->renderer->json($res, ["error" => "Failed to create customer"], [], 500);
        }

        return $this->renderer->json($res, $newCustomer, [], 201);
    }

    public function update(Request $req, Response $res, $args): Response
    {
        $id = $args['id'];
        $data = $req->getParsedBody();

        if (!isset($id) || !$data) {
            return $this->renderer->json($res, ["error" => "Invalid input data"], [], 400);
        }

        $updatedCustomer = $this->customer->update($data);

        if (!$updatedCustomer instanceof Customer) {
            return $this->renderer->json($res, ["error" => "Customer not found or update failed"], [], 404);
        }

        return $this->renderer->json($res, $updatedCustomer);
    }

    public function delete(Request $req, Response $res, $args): Response
    {
        $id = $args['id'];

        if (!isset($id)) {
            return $this->renderer->json($res, ["error" => "No id specified"], [], 400);
        }

        $result = $this->customer->delete($id);

        if (!$result) {
            return $this->renderer->json($res, ["error" => "Customer not found or delete failed"], [], 404);
        }

        return $this->renderer->json($res, ["message" => "Customer deleted successfully"], [], 200);
    }
}