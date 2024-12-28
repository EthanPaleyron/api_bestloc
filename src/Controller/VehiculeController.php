<?php
namespace App\Controller;
use App\Renderer\JsonRenderer;
use BestLoc\Service\VehiculeService;
use BestLoc\Entity\Vehicule;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class VehiculeController
{
    private VehiculeService $vehicule;
    private JsonRenderer $renderer;

    public function __construct()
    {
        $this->vehicule = new VehiculeService();
        $this->renderer = new JsonRenderer();
    }

    public function getById(Request $req, Response $res, $args): Response
    {
        $id = $args['id'];

        if (!isset($id)) {
            return $this->renderer->json($res, ["error" => "No id specified"], [], 404);
        }

        $vehicule = $this->vehicule->find($id);

        if (!$vehicule instanceof Vehicule) {
            return $this->renderer->json($res, ["error" => "vehicule not found"], [], 404);
        }

        return $this->renderer->json($res, $vehicule);
    }

    public function getAll(Request $req, Response $res, $args): Response
    {
        $vehicules = $this->vehicule->findAll();
        return $this->renderer->json($res, $vehicules);
    }

    public function create(Request $req, Response $res): Response
    {
        $data = $req->getParsedBody();

        if (!$data) {
            return $this->renderer->json($res, ["error" => "Invalid input data"], [], 400);
        }

        $newvehicule = $this->vehicule->create($data);

        if (!$newvehicule instanceof Vehicule) {
            return $this->renderer->json($res, ["error" => "Failed to create vehicule"], [], 500);
        }

        return $this->renderer->json($res, $newvehicule, [], 201);
    }

    public function update(Request $req, Response $res, $args): Response
    {
        $id = $args['id'];
        $data = $req->getParsedBody();

        if (!isset($id) || !$data) {
            return $this->renderer->json($res, ["error" => "Invalid input data"], [], 400);
        }

        $updatedvehicule = $this->vehicule->update($data);

        if (!$updatedvehicule instanceof Vehicule) {
            return $this->renderer->json($res, ["error" => "vehicule not found or update failed"], [], 404);
        }

        return $this->renderer->json($res, $updatedvehicule);
    }

    public function delete(Request $req, Response $res, $args): Response
    {
        $id = $args['id'];

        if (!isset($id)) {
            return $this->renderer->json($res, ["error" => "No id specified"], [], 400);
        }

        $result = $this->vehicule->delete($id);

        if (!$result) {
            return $this->renderer->json($res, ["error" => "vehicule not found or delete failed"], [], 404);
        }

        return $this->renderer->json($res, ["message" => "vehicule deleted successfully"], [], 200);
    }
}