<?php

declare(strict_types=1);

/*
 * Copyright (C) 2024-2026 Rafael San José <rsanjose@alxarafe.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

namespace Alxarafe\Service;

/**
 * Class PdfService.
 *
 * Generic PDF generation service using DOMPDF.
 * Renders Blade templates to PDF format.
 *
 * Requires: dompdf/dompdf
 *
 * Usage:
 *   $pdf = PdfService::render('invoice', ['order' => $order]);
 *   PdfService::download('invoice', ['order' => $order], 'invoice_001.pdf');
 */
class PdfService
{
    /**
     * Render a Blade template to PDF and return the PDF content as a string.
     *
     * @param string $template Blade template path (e.g., 'pdf/invoice')
     * @param array  $data     Data to pass to the template
     * @param array  $options  DOMPDF options (paper size, orientation, etc.)
     * @return string PDF content
     */
    public static function render(string $template, array $data = [], array $options = []): string
    {
        $html = self::renderHtml($template, $data);
        return self::htmlToPdf($html, $options);
    }

    /**
     * Render a Blade template to PDF and send as HTTP download.
     *
     * @param string $template Blade template path
     * @param array  $data     Data to pass to the template
     * @param string $filename Download filename (e.g., 'invoice_001.pdf')
     * @param array  $options  DOMPDF options
     */
    public static function download(string $template, array $data, string $filename, array $options = []): void
    {
        $pdf = self::render($template, $data, $options);
        self::sendPdfResponse($pdf, $filename, 'attachment');
    }

    /**
     * Render a Blade template to PDF and display inline in the browser.
     *
     * @param string $template Blade template path
     * @param array  $data     Data to pass to the template
     * @param string $filename Suggested filename
     * @param array  $options  DOMPDF options
     */
    public static function inline(string $template, array $data, string $filename = 'document.pdf', array $options = []): void
    {
        $pdf = self::render($template, $data, $options);
        self::sendPdfResponse($pdf, $filename, 'inline');
    }

    /**
     * Convert raw HTML to PDF content.
     *
     * @param string $html    Full HTML document
     * @param array  $options DOMPDF configuration options
     * @return string PDF binary content
     */
    public static function htmlToPdf(string $html, array $options = []): string
    {
        $dompdfOptions = new \Dompdf\Options();
        $dompdfOptions->setIsRemoteEnabled(true);
        $dompdfOptions->setDefaultFont($options['font'] ?? 'DejaVu Sans');

        if (isset($options['temp_dir'])) {
            $dompdfOptions->setTempDir($options['temp_dir']);
        }

        $dompdf = new \Dompdf\Dompdf($dompdfOptions);
        $dompdf->loadHtml($html);
        $dompdf->setPaper(
            $options['paper'] ?? 'A4',
            $options['orientation'] ?? 'portrait'
        );
        $dompdf->render();

        return $dompdf->output();
    }

    /**
     * Render a Blade template to HTML string.
     *
     * @param string $template Template path (relative to templates dir)
     * @param array  $data     Template data
     * @return string Rendered HTML
     */
    private static function renderHtml(string $template, array $data): string
    {
        $viewPaths = [];

        // Collect template paths from the framework if available
        if (defined('TEMPLATES_PATH')) {
            $viewPaths[] = constant('TEMPLATES_PATH');
        }
        if (defined('ALX_PATH')) {
            $viewPaths[] = constant('ALX_PATH') . '/templates';
        }
        if (defined('BASE_PATH')) {
            $viewPaths[] = constant('BASE_PATH') . '/templates';
        }

        // Fallback
        if (empty($viewPaths)) {
            $viewPaths[] = dirname(__DIR__, 3) . '/templates';
        }

        $cachePath = defined('ALX_CACHE') ? constant('ALX_CACHE') . '/blade' : sys_get_temp_dir() . '/blade';

        if (!is_dir($cachePath)) {
            mkdir($cachePath, 0755, true);
        }

        $blade = new \Jenssegers\Blade\Blade($viewPaths, $cachePath);
        return $blade->render($template, $data);
    }

    /**
     * Send PDF content as an HTTP response.
     *
     * @param string $content     PDF binary content
     * @param string $filename    Suggested filename
     * @param string $disposition 'inline' or 'attachment'
     */
    private static function sendPdfResponse(string $content, string $filename, string $disposition): void
    {
        header('Content-Type: application/pdf');
        header("Content-Disposition: {$disposition}; filename=\"{$filename}\"");
        header('Content-Length: ' . strlen($content));
        header('Cache-Control: private, max-age=0, must-revalidate');
        echo $content;
        exit;
    }

    /**
     * Save a rendered PDF to a file.
     *
     * @param string $template Blade template path
     * @param array  $data     Template data
     * @param string $filePath Absolute path where to save the PDF
     * @param array  $options  DOMPDF options
     * @return bool True if file was saved successfully
     */
    public static function save(string $template, array $data, string $filePath, array $options = []): bool
    {
        $pdf = self::render($template, $data, $options);
        $dir = dirname($filePath);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        return file_put_contents($filePath, $pdf) !== false;
    }
}
