<?php
namespace PhlyBlog\Compiler;

use Laminas\View\View;

class ResponseStrategy
{
    protected $file;
    protected $writer;

    public function __construct(WriterInterface $writer, ResponseFile $file)
    {
        $this->writer = $writer;
        $this->file   = $file;
        $view = new View();
        $view->addResponseStrategy(array($this, 'onResponse'));
    }

    public function onResponse($e)
    {
        $result = $e->getResult();
        $file   = $this->file->getFilename();
        if (preg_match('/-p1.html$/', $file)) {
            $file = preg_replace('/-p1(\.html)$/', '$1', $file);
        }
        $file = str_replace(' ', '+', $file);
        $this->writer->write($file, $result);
    }
}
