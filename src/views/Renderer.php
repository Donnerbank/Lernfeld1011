<?php

namespace Lernfeld1011\views;

use Exception;

class Renderer
{
    /** Returns the basepath of this project
     */
    public static function getBasePath(): string
    {
        return dirname($_SERVER['PHP_SELF']);
    }

    /**
     * @throws \Exception
     */
    public static function run(string $viewFile, array $payload = []): string
    {
        if (! file_exists($viewFile)) {
            throw new Exception('View File not found: '.$viewFile);
        }

        //Example: $payload = ['date' => 'timestamp here', 'temperature' => '2']
        extract($payload, EXTR_PREFIX_SAME, 'data');

        //ob-Stuff: Prevents echos and html code to be rendered. Catches those.
        //ob get clean returns the cought output and allows html and echos to render again.
        ob_start();
        ob_implicit_flush(false);
        require $viewFile;
        $result = ob_get_clean();

        if ($result) {
            return $result;
        }

        throw new Exception('Renderer has failed its mission. No Ghoulash');
    }
}
