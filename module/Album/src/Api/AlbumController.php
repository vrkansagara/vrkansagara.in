<?php

namespace Album\Api;

use Album\Model\SearchTable;
use Exception;
use Laminas\Mvc\Controller\AbstractRestfulController;

class AlbumController extends AbstractRestfulController
{
    // Add this property:
    private $table;

    // Add this constructor:
    public function __construct(SearchTable $table)
    {
        $this->table = $table;
    }

    public function get($id)
    {
        // associated with GET request with identifier
    }

    public function getList()
    {
        try {
            $data = $this->table->fetchAll();
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    public function create($data)
    {
        // associated with POST request
    }

    public function update($id, $data)
    {
        // associated with PUT request
    }

    public function delete($id)
    {
        // associated with DELETE request
    }
}
