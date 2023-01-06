<?php

namespace App;

use App\Exceptions\MissingVariableException;

class HtmlRender extends AbstractRender
{
    protected function getContent(): string
    {
        $fileSystem = new FS('../src/html/Dashboard.html');
        $fileContent = $fileSystem->getFileContent();

        $duomMas = [
            'username' => $_SESSION['username'],
            'userType' => 'Admin',
            'loggedInDate' => date('Y-m-d H:i:s'),
            'nera_sito_raktazodzio' => 'Turi ismesti klaida',
        ];

        foreach ($duomMas as $key => $value) {
            if (!str_contains($fileContent, '{{' . $key . '}}')) {
                throw new MissingVariableException('Nerastas raktazodis: ' . $key);
            }
            $fileContent = str_replace('{{' . $key . '}}', $value, $fileContent);
        }

        return $fileContent;
    }
}