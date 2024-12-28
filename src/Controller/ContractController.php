<?php
namespace App\Controller;
use App\Renderer\JsonRenderer;
use BestLoc\Service\ContractService;
use BestLoc\Entity\Contract;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ContractController
{
    private ContractService $contract;
    private JsonRenderer $renderer;

    public function __construct()
    {
        $this->contract = new ContractService();
        $this->renderer = new JsonRenderer();
    }

    public function getById(Request $req, Response $res, $args): Response
    {
        $id = $args['id'];

        if (!isset($id)) {
            return $this->renderer->json($res, ["error" => "No id specified"], [], 404);
        }

        $contract = $this->contract->find($id);

        if (!$contract instanceof Contract) {
            return $this->renderer->json($res, ["error" => "Contract not found"], [], 404);
        }

        return $this->renderer->json($res, $contract);
    }

    public function getAll(Request $req, Response $res, $args): Response
    {
        $contracts = $this->contract->getAll();
        return $this->renderer->json($res, $contracts);
    }

    public function create(Request $req, Response $res): Response
    {
        $newContract = $this->contract->create(100, 50, "29/11/2005", "30/12/2005", "30/12/2005", "30/12/2005", 30);

        if (!$newContract instanceof Contract) {
            return $this->renderer->json($res, ["error" => "Failed to create contract"], [], 500);
        }

        return $this->renderer->json($res, $newContract, [], 201);
    }

    public function update(Request $req, Response $res, $args): Response
    {
        $id = $args['id'];

        $updatedContract = $this->contract->update($id, 100, 50, "29/11/2005", "30/12/2005", "30/12/2005", "30/12/2005", 30);

        if (!$updatedContract instanceof Contract) {
            return $this->renderer->json($res, ["error" => "Contract not found or update failed"], [], 404);
        }

        return $this->renderer->json($res, $updatedContract);
    }

    public function delete(Request $req, Response $res, $args): Response
    {
        $id = $args['id'];

        if (!isset($id)) {
            return $this->renderer->json($res, ["error" => "No id specified"], [], 400);
        }

        $result = $this->contract->delete($id);

        if (!$result) {
            return $this->renderer->json($res, ["error" => "Contract not found or delete failed"], [], 404);
        }

        return $this->renderer->json($res, ["message" => "Contract deleted successfully"], [], 200);
    }
}