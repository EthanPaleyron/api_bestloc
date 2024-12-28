<?php
namespace App\Controller;
use App\Renderer\JsonRenderer;
use BestLoc\Service\BillingService;
use BestLoc\Entity\Billing;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class BillingController
{
    private BillingService $billing;
    private JsonRenderer $renderer;
    public function __construct()
    {
        $this->billing = new BillingService();
        $this->renderer = new JsonRenderer();
    }

    public function getById(Request $req, Response $res, $args): Response
    {
        $id = $args['id'];

        if (!isset($id)) {
            return $this->renderer->json($res, ["error" => "no id specified"], [], 404);
        }

        $billing = $this->billing->find($id);

        if (!$billing instanceof Billing) {
            return $this->renderer->json($res, ["error" => "Billing not found"], [], 404);
        }

        return $this->renderer->json($res, $billing);
    }

    public function getAll(Request $req, Response $res, $args): Response
    {
        $billing = $this->billing->getAll();
        return $this->renderer->json($res, $billing);
    }

    public function create(Request $req, Response $res): Response
    {
        $newBilling = $this->billing->create(15, 100000);

        if (!$newBilling instanceof Billing) {
            return $this->renderer->json($res, ["error" => "Failed to create billing"], [], 500);
        }

        return $this->renderer->json($res, $newBilling, [], 201);
    }

    public function update(Request $req, Response $res, $args): Response
    {
        $id = $args['id'];
        $data = $req->getParsedBody();

        if (!isset($id) || !$data) {
            return $this->renderer->json($res, ["error" => "Invalid input data"], [], 400);
        }

        $updatedBilling = $this->billing->update($id, 15, 100000);

        if (!$updatedBilling instanceof Billing) {
            return $this->renderer->json($res, ["error" => "Billing not found or update failed"], [], 404);
        }

        return $this->renderer->json($res, $updatedBilling);
    }

    public function delete(Request $req, Response $res, $args): Response
    {
        $id = $args['id'];

        if (!isset($id)) {
            return $this->renderer->json($res, ["error" => "No id specified"], [], 400);
        }

        $result = $this->billing->delete($id);

        if (!$result) {
            return $this->renderer->json($res, ["error" => "Billing not found or delete failed"], [], 404);
        }

        return $this->renderer->json($res, ["message" => "Billing deleted successfully"], [], 200);
    }
}