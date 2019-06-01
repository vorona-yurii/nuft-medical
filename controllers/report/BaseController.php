<?php

namespace app\controllers\report;

use Yii;
use PhpOffice\PhpWord\PhpWord;
use yii\web\Controller;

class BaseController extends Controller
{
    private $templateDir = '@app/views/report/templates/';
    protected $template = null;

    private $document = null;
    protected $documentValues = [];
    protected $documentTables = [];

    protected function createAndReturnDocument()
    {
        $this->initDocument();
        $this->fillDocument();
        $this->returnDocumentForDownload();
    }

    protected function initDocument()
    {
        $PHPWord = new PHPWord();
        $templateFullPath = Yii::getAlias($this->templateDir.$this->template);

        $this->document = $PHPWord->loadTemplate($templateFullPath);
    }

    protected function fillDocument()
    {
        foreach ($this->documentValues as $key => $value) {
            $this->document->setValue($key, $value);
        }

        // $this->document->cloneRow('tableRow', 5);
    }

    protected function returnDocumentForDownload($attachmentName = 'Report.docx')
    {
        $attachment = $this->document->save();
        if (file_exists($attachment)) {
            Yii::$app->response->sendFile($attachment, $attachmentName);
            unlink($attachment);
        } else {
            echo 'An error occurred while creating the file';
        }
    }
}
