<?php

namespace Elcodi\Component\StateTransitionMachine\Exception;

use Exception;

/**
 * Class MissingWorkflowLineStackGetterNameException.
 */
class MissingWorkflowLineStackGetterNameException extends Exception
{
    /**
     * Exception constructor.
     *
     * @param int       $code     [optional] The Exception code.
     * @param Exception $previous [optional] The previous exception used for the exception chaining. Since 5.3.0
     */
    public function __construct( $code = 0, Exception $previous = null)
    {
        $message = 'Workflow stack line getter name is missing.';

        parent::__construct($message, $code, $previous);
    }
}
