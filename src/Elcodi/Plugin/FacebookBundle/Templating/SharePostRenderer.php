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

namespace Elcodi\Plugin\FacebookBundle\Templating;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Translation\TranslatorInterface;

use Elcodi\Component\Plugin\Entity\Plugin;
use Elcodi\Component\Plugin\EventDispatcher\Interfaces\EventInterface;
use Elcodi\Component\Plugin\Templating\Traits\TemplatingTrait;
use Elcodi\Component\Article\Entity\Article;

/**
 * Class SharePostRenderer
 */
class SharePostRenderer
{
    use TemplatingTrait;

    /**
     * @var Plugin
     *
     * Plugin
     */
    protected $plugin;

    /**
     * @var UrlGeneratorInterface
     *
     * An url generator
     */
    protected $urlGenerator;

    /**
     * @var TranslatorInterface
     *
     * A translator
     */
    protected $translator;

    /**
     * Builds a new share tweet renderer class.
     *
     * @param UrlGeneratorInterface $urlGenerator An url generator
     * @param TranslatorInterface   $translator   A translator
     */
    public function __construct(
        UrlGeneratorInterface $urlGenerator,
        TranslatorInterface $translator
    ) {
        $this->urlGenerator = $urlGenerator;
        $this->translator = $translator;
    }

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
     * Renders the share article button.
     *
     * @param EventInterface $event The event
     */
    public function renderShareArticle(EventInterface $event)
    {
        if ($this
            ->plugin
            ->isUsable()
        ) {
            /**
             * @var Article $article
             */
            $article = $event->get('article');

            $shareUrl = $this
                ->urlGenerator
                ->generate(
                    'store_article_view',
                    [
                        'id'   => $article->getId(),
                        'slug' => $article->getSlug(),
                    ],
                    true
                );

            $this->appendTemplate(
                '@ElcodiFacebook/Post/share.html.twig',
                $event,
                $this->plugin,
                [
                    'url' => $shareUrl,
                ]
            );
        }
    }

    /**
     * Renders the share article button.
     *
     * @param EventInterface $event The event
     */
    public function renderShareOrder(EventInterface $event)
    {
        if ($this
            ->plugin
            ->isUsable()
        ) {
            $shareUrl = $this
                ->urlGenerator
                ->generate(
                    'store_homepage',
                    [],
                    true
                );

            $this->appendTemplate(
                '@ElcodiFacebook/Post/share.html.twig',
                $event,
                $this->plugin,
                [
                    'url' => $shareUrl,
                ]
            );
        }
    }
}
