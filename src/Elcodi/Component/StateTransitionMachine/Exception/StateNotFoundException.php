<?php

namespace Elcodi\Component\StateTransitionMachine\Exception;

use Exception;

/**
 * Class StateNotFoundException.
 */
class StateNotFoundException extends Exception
{
    /**
     * Exception constructor.
     *
     * @param string    $state    Invalid state
     * @param int       $code     [optional] The Exception code.
     * @param Exception $previous [optional] The previous exception used for the exception chaining. Since 5.3.0
     */
    public function __construct($state, $code = 0, Exception $previous = null)
    {
        $message = 'State "' . $state . '" wasn\'t found in database';

        parent::__construct($message, $code, $previous);
    }
}
