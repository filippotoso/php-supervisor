<?php

namespace FilippoToso\PhpSupervisor;

use Closure;

class Supervisor
{

    /**
     * Run a closure with a long lived script.
     *
     * @param Closure $closure  The anonymous function containing a long lived script
     * @param string $lockFile  The path of the lock file. This will be used to avoid multiple parallel execution of the closure.
     * @param string $stopFile  The path of the stop file. If it exists, supervisors will stop at the next exit of the closure. It's usefull to reload the script in case of changes to the code.
     * @return void
     */
    public static function run(Closure $closure, string $lockFile = null, string $stopFile = null)
    {
        $lockFile = $lockFile ?? tempnam(sys_get_temp_dir(), 'supervisor-');

        while (!file_exists($stopFile)) {

            $handle = fopen($lockFile, 'w+');

            if (flock($handle, LOCK_EX | LOCK_NB)) {
                $closure();
            } else {
                break;
            }

            fclose($handle);
        }

        if (file_exists($stopFile)) {
            unlink($stopFile);
        }
    }
}
