<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;

class FilesTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    public function testSendFileAndData()
    {
        $file = TESTPATH . '_support/code.jpeg';

        $_FILES = [
            'image' => [
                'name' => 'code',
                'type' => 'img/jpeg',
                'size' => filesize($file),
                'tmp_name' => $file,
                'error' => 0
            ]
        ];

        $request = $this->withHeaders([
            'Content-Type' => 'multipart/form-data'
        ])->post('test', [
            'field' => 'asdf'
        ]);

        $request->assertJSONFragment([
            'field' => true,
            'image' => true
        ]);
    }
}
