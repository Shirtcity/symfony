<?php

namespace Elcodi\Component\StateTransitionMachine\Exception;

use Exception;

/**
 * Class InvalidWorkflowLineStackGetterException.
 */
class InvalidWorkflowLineStackGetterException extends Exception
{
    /**
     * Exception constructor.
     *
     * @param string    $getter   Invalid getter name
     * @param int       $code     [optional] The Exception code.
     * @param Exception $previous [optional] The previous exception used for the exception chaining. Since 5.3.0
     */
    public function __construct($getter, $code = 0, Exception $previous = null)
    {
        $message = 'Workflow stack line getter with name ' . $getter . ' wasn\'t found';

        parent::__construct($message, $code, $previous);
    }
}
