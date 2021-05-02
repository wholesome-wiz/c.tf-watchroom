<?php

namespace App\Database\Schema;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Database\RecordsNotFoundException;
use Illuminate\Support\Facades\Storage;

/**
 * Denotes a type of database object which is immutable.
 *
 * @package App\
 */
abstract class Definition implements Arrayable, Jsonable
{
    /**
     * Where is this definition located?
     *
     * @var string
     */
    protected $location;

    /**
     * The key/name of a definition.
     *
     * @var string
     * @default ''
     */
    protected $key = '';

    /**
     * The disk this defintion is located on.
     *
     * @var string
     * @default 'local-def'
     */
    protected $disk = 'local-def';

    /**
     * The contents of a definition.
     *
     * @var array
     * @default an empty array
     */
    protected $contents = [];

    /**
     * Create a new instance of the given definition.
     *
     * @return static
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function __construct(string $key = '')
    {
        $contents = Storage::disk($this->disk)->get($this->location);
        $contents = json_decode($contents, true);

        $this->key = $key;
        $this->contents = $this->transform($contents);
    }

    /**
     * Applies any necessary transformations to obtain our data.
     *
     * @param array $original
     *
     * @return array
     */
    protected function transform(array $original): array
    {
        try
        {
            if (!empty($this->key))
            {
                return $original[$this->key];
            }
            return $original;
        }
        catch (\ErrorException $error)
        {
            // This exception confirms better to what we're doing plus this will create a 404 if unhandled.
            throw new RecordsNotFoundException("$this->key not found.");
        }
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->contents;
    }

    /**
     * @param int $options
     *
     * @return string
     */
    public function toJson($options = 0): string
    {
        return json_encode($this->contents, $options);
    }
}
