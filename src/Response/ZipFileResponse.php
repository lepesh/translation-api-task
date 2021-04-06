<?php
declare(strict_types=1);

namespace App\Response;

use Symfony\Component\HttpFoundation\Response;

class ZipFileResponse extends Response
{
    public function __construct(string $content, string $filename)
    {
        parent::__construct($content, Response::HTTP_OK, [
            'Cache-Control' => 'private',
            'Content-type' => 'application/zip',
            'Content-Disposition' => sprintf('attachment; filename="%s";', $filename)
        ]);
    }
}
