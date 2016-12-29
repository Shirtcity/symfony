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

namespace Elcodi\Plugin\ArticleCsvBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\StreamedResponse;

use Elcodi\Component\Plugin\Entity\Plugin;
use Elcodi\Plugin\ArticleCsvBundle\Services\ArticleExporter;

/**
 * Class Controller for ElcodiArticleCsvBundle plugin
 *
 * @author Berny Cantos <be@rny.cc>
 */
class CsvController extends Controller
{
    /**
     * Export all plugins
     *
     * @return Response Exportation file
     */
    public function exportAction()
    {
        /**
         * @var Plugin $plugin
         */
        $plugin = $this
            ->get('elcodi.manager.plugin')
            ->getPlugin('Elcodi\Plugin\ArticleCsvBundle');

        if (!$plugin->isUsable()) {
            $this->createNotFoundException(
                $this
                    ->get('translator')
                    ->trans('article_csv_plugin.error.is_disabled')
            );
        }

        /**
         * @var ArticleExporter $exporter
         */
        $exporter = $this->get('elcodi_plugin.article_csv.exporter');
        $repository = $this->get('elcodi.repository.article');

        $response = StreamedResponse::create();
        $response->setCallback(function () use ($repository, $exporter) {
            $rows = $repository->findAll();

            $exporter->export($rows);
        });

        $configuration = $plugin->getConfiguration();

        $filename = $configuration['export_filename'];
        if (empty($filename)) {
            $filename = 'articles.csv';
        }

        return $this
            ->makeDownloadable(
                $response,
                $filename,
                'text/csv'
            );
    }

    /**
     * Create an HTTP download file from content
     *
     * @param Response $response    Content of the response
     * @param string   $filename    Name that will prompt in the download
     * @param string   $contentType MIME type for the downloaded file
     *
     * @return Response
     */
    protected function makeDownloadable(Response $response, $filename, $contentType)
    {
        $dispositionHeader = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $filename
        );

        $response->headers->set('Content-Disposition', $dispositionHeader);
        $response->headers->set('Content-Type', $contentType);

        return $response;
    }
}
