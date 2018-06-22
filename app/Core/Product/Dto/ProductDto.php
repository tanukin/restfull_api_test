<?php

namespace App\Core\Product\Dto;

class ProductDto
{
    const OFFSET_DEFAULT = 0;
    const LIMIT_DEFAULT = 100;

    /**
     * @var int
     */
    private $offset;

    /**
     * @var int
     */
    private $limit;

    /**
     * @return int
     */
    public function getOffset(): int
    {
        return $this->offset ?: self::OFFSET_DEFAULT;
    }

    /**
     * @param int|null $offset
     */
    public function setOffset(?int $offset): void
    {
        $this->offset = $offset;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit ?: self::LIMIT_DEFAULT;
    }

    /**
     * @param int|null $limit
     */
    public function setLimit(?int $limit): void
    {
        $this->limit = $limit;
    }

}