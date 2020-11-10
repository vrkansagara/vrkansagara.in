<?php

namespace Application\Model;

use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\Sql\Select;
use Laminas\Db\TableGateway\TableGatewayInterface;
use RuntimeException;

class SearchTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    public function saveSearch(Search $album)
    {
        $data = [
            'artist' => $album->artist,
            'title' => $album->title,
        ];

        $id = (int)$album->id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        try {
            $this->getSearch($id);
        } catch (RuntimeException $e) {
            throw new RuntimeException(sprintf(
                'Cannot update album with identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function getSearch($id)
    {
        $id = (int)$id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (!$row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        return $row;
    }

    public function deleteSearch($id)
    {
        $this->tableGateway->delete(['id' => (int)$id]);
    }

    public function search($name): ResultSet
    {
        // search for at most 2 artists who's name starts with Brit, ascending
        /** @var $rowset ResultSet */
        $rowset = $this->tableGateway->select(function (Select $select) use ($name) {
            $select->where->like('content', "%$name%");
//            $select->where->like('tags', "%$name%");
            $select->order('url DESC')->limit(10);
        });

        return $rowset;
    }

    public function cleanSearchData($type)
    {
        if ($type == 'blog') {
            // Remove all records.
            $this->tableGateway->delete(['type' => (string)$type]);
        }
    }

    public function insertSearchData($content, $tags, $url, $type)
    {
        $data = [
            'content' => strip_tags($content),
            'tags' => implode(',', $tags),
            'url' => $url,
            'type' => $type
        ];
        $this->tableGateway->insert($data);
    }
}
