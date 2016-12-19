<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Plugin\ProductCsvBundle\Templating;

use Elcodi\Component\Plugin\Entity\Plugin;
use Elcodi\Component\Plugin\EventDispatcher\Interfaces\EventInterface;
use Elcodi\Component\Plugin\Templating\Traits\TemplatingTrait;

/**
 * Renders import/export buttons in Twig
 *
 * @author Berny Cantos <be@rny.cc>
 */
class TwigRenderer
{
    use TemplatingTrait;

    /**
     * @var Plugin
     *
     * Plugin
     */
    protected $plugin;

    /**
     * Set plugin
     *
     * @param Plugin $plugin Plugin
     *
     * @return $this Self object
     */
    public function setPlugin(Plugin $plugin)
    {
        $this->plugin = $plugin;

        return $this;
    }

    /**
     * Renders import/export buttons
     *
     * @param EventInterface $event
     *
     * @return string
     */
    public function renderButtons(EventInterface $event)
    {
        if ($event->get('entity_type') !== 'product') {
            return null;
        }

        if ($this
            ->plugin
            ->isUsable()
        ) {
            $this->appendTemplate(
                'ElcodiProductCsvBundle::buttons.html.twig',
                $event,
                $this->plugin
            );
        }
    }
}
