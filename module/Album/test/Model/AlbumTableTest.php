<?php

declare(strict_types=1);

namespace AlbumTest\Model;

use Album\Model\Search;
use Album\Model\SearchTable;
use Laminas\Db\ResultSet\ResultSetInterface;
use Laminas\Db\TableGateway\TableGatewayInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use RuntimeException;

use function array_filter;
use function in_array;

use const ARRAY_FILTER_USE_KEY;

class AlbumTableTest extends TestCase
{
    use ProphecyTrait;

    protected function setUp(): void
    {
        $this->tableGateway = $this->prophesize(TableGatewayInterface::class);
        $this->albumTable   = new SearchTable($this->tableGateway->reveal());
    }

    public function testFetchAllReturnsAllAlbums()
    {
        $resultSet = $this->prophesize(ResultSetInterface::class)->reveal();
        $this->tableGateway->select()->willReturn($resultSet);

        $this->assertSame($resultSet, $this->albumTable->fetchAll());
    }

    public function testCanDeleteAnAlbumByItsId()
    {
        $this->tableGateway->delete(['id' => 123])->shouldBeCalled();
        $this->albumTable->deleteAlbum(123);
    }

    public function testSaveAlbumWillInsertNewAlbumsIfTheyDontAlreadyHaveAnId()
    {
        $albumData = [
            'artist' => 'The Military Wives',
            'title'  => 'In My Dreams',
        ];
        $album     = new Search();
        $album->exchangeArray($albumData);

        $this->tableGateway->insert($albumData)->shouldBeCalled();
        $this->albumTable->saveAlbum($album);
    }

    public function testSaveAlbumWillUpdateExistingAlbumsIfTheyAlreadyHaveAnId()
    {
        $albumData = [
            'id'     => 123,
            'artist' => 'The Military Wives',
            'title'  => 'In My Dreams',
        ];
        $album     = new Search();
        $album->exchangeArray($albumData);

        $resultSet = $this->prophesize(ResultSetInterface::class);
        $resultSet->current()->willReturn($album);

        $this->tableGateway
            ->select(['id' => 123])
            ->willReturn($resultSet->reveal());
        $this->tableGateway
            ->update(
                array_filter($albumData, function ($key) {
                    return in_array($key, ['artist', 'title']);
                }, ARRAY_FILTER_USE_KEY),
                ['id' => 123]
            )->shouldBeCalled();

        $this->albumTable->saveAlbum($album);
    }

    public function testExceptionIsThrownWhenGettingNonExistentAlbum()
    {
        $resultSet = $this->prophesize(ResultSetInterface::class);
        $resultSet->current()->willReturn(null);

        $this->tableGateway
            ->select(['id' => 123])
            ->willReturn($resultSet->reveal());

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Could not find row with identifier 123');
        $this->albumTable->getAlbum(123);
    }
}
