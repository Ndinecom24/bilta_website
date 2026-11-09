<?php

namespace App\Services\Support;

use RuntimeException;
use ZipArchive;

/**
 * Minimal, dependency-free .xlsx writer (one sheet, text + numbers, bold header, frozen header row).
 * Needs PHP's zip extension. Text is stored as inline strings so nothing can be evaluated as a formula.
 */
class XlsxWriter
{
    /**
     * @param string $title    sheet / report title (first row)
     * @param array  $subtitle lines shown under the title (e.g. filters, generated at)
     * @param array  $columns  header labels
     * @param array  $rows     list of row arrays (ints/floats are written as numbers)
     * @param array  $totals   list of [label, value] pairs written below the table
     *
     * @return string path to a temporary file (caller deletes it)
     */
    public static function build(string $title, array $subtitle, array $columns, array $rows, array $totals = []): string
    {
        if (!class_exists(ZipArchive::class)) {
            throw new RuntimeException('The PHP zip extension is required for Excel export.');
        }

        $lines = [];
        $r = 1;

        $lines[] = self::row($r++, [[$title, 1]]);
        foreach ($subtitle as $line) {
            $lines[] = self::row($r++, [[(string) $line, 0]]);
        }
        $r++; // blank spacer

        $headerRow = $r;
        $lines[] = self::row($r++, array_map(function ($c) {
            return [(string) $c, 2];
        }, $columns));

        $widths = array_map(function ($c) {
            return mb_strlen((string) $c);
        }, $columns);

        foreach ($rows as $row) {
            $cells = [];
            foreach (array_values($row) as $i => $value) {
                $cells[] = [$value, 0];
                $len = is_scalar($value) ? mb_strlen((string) $value) : 0;
                $widths[$i] = min(60, max($widths[$i] ?? 0, $len));
            }
            $lines[] = self::row($r++, $cells);
        }

        if ($totals) {
            $r++;
            foreach ($totals as [$label, $value]) {
                $lines[] = self::row($r++, [[(string) $label, 1], [$value, 1]]);
            }
        }

        $cols = '';
        foreach ($widths as $i => $w) {
            $n = $i + 1;
            $cols .= '<col min="' . $n . '" max="' . $n . '" width="' . ($w + 3) . '" customWidth="1"/>';
        }

        $sheet = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
            . '<sheetViews><sheetView workbookViewId="0"><pane ySplit="' . $headerRow . '" topLeftCell="A' . ($headerRow + 1) . '" activePane="bottomLeft" state="frozen"/></sheetView></sheetViews>'
            . '<cols>' . $cols . '</cols>'
            . '<sheetData>' . implode('', $lines) . '</sheetData>'
            . '</worksheet>';

        $sheetName = self::xml(mb_substr(preg_replace('/[\\\\\/\?\*\[\]:]/', ' ', $title), 0, 31) ?: 'Report');

        $path = tempnam(sys_get_temp_dir(), 'xlsx');
        $zip = new ZipArchive();
        if ($zip->open($path, ZipArchive::OVERWRITE) !== true) {
            throw new RuntimeException('Could not create the Excel file.');
        }

        $zip->addFromString('[Content_Types].xml',
            '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">'
            . '<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>'
            . '<Default Extension="xml" ContentType="application/xml"/>'
            . '<Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>'
            . '<Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>'
            . '<Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/>'
            . '</Types>');

        $zip->addFromString('_rels/.rels',
            '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>'
            . '</Relationships>');

        $zip->addFromString('xl/workbook.xml',
            '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'
            . '<sheets><sheet name="' . $sheetName . '" sheetId="1" r:id="rId1"/></sheets></workbook>');

        $zip->addFromString('xl/_rels/workbook.xml.rels',
            '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>'
            . '<Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>'
            . '</Relationships>');

        // 0 = normal, 1 = bold, 2 = bold on grey (header)
        $zip->addFromString('xl/styles.xml',
            '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
            . '<fonts count="2"><font><sz val="11"/><name val="Calibri"/></font><font><b/><sz val="11"/><name val="Calibri"/></font></fonts>'
            . '<fills count="3"><fill><patternFill patternType="none"/></fill><fill><patternFill patternType="gray125"/></fill>'
            . '<fill><patternFill patternType="solid"><fgColor rgb="FFE5EAF2"/><bgColor indexed="64"/></patternFill></fill></fills>'
            . '<borders count="1"><border><left/><right/><top/><bottom/><diagonal/></border></borders>'
            . '<cellStyleXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0"/></cellStyleXfs>'
            . '<cellXfs count="3">'
            . '<xf numFmtId="0" fontId="0" fillId="0" borderId="0" xfId="0"/>'
            . '<xf numFmtId="0" fontId="1" fillId="0" borderId="0" xfId="0" applyFont="1"/>'
            . '<xf numFmtId="0" fontId="1" fillId="2" borderId="0" xfId="0" applyFont="1" applyFill="1"/>'
            . '</cellXfs></styleSheet>');

        $zip->addFromString('xl/worksheets/sheet1.xml', $sheet);
        $zip->close();

        return $path;
    }

    /** @param array $cells list of [value, styleIndex] */
    private static function row(int $r, array $cells): string
    {
        $xml = '<row r="' . $r . '">';
        foreach ($cells as $i => [$value, $style]) {
            $ref = self::column($i) . $r;
            $s = $style ? ' s="' . $style . '"' : '';

            if ($value === null || $value === '') {
                $xml .= '<c r="' . $ref . '"' . $s . '/>';
            } elseif (is_int($value) || is_float($value)) {
                $xml .= '<c r="' . $ref . '"' . $s . '><v>' . $value . '</v></c>';
            } else {
                $xml .= '<c r="' . $ref . '"' . $s . ' t="inlineStr"><is><t xml:space="preserve">' . self::xml((string) $value) . '</t></is></c>';
            }
        }

        return $xml . '</row>';
    }

    private static function column(int $index): string
    {
        $name = '';
        for ($n = $index + 1; $n > 0; $n = intdiv($n - 1, 26)) {
            $name = chr(65 + ($n - 1) % 26) . $name;
        }

        return $name;
    }

    private static function xml(string $text): string
    {
        // drop characters that are illegal in XML 1.0
        $text = preg_replace('/[^\x{9}\x{A}\x{D}\x{20}-\x{D7FF}\x{E000}-\x{FFFD}]/u', '', $text) ?? '';

        return htmlspecialchars($text, ENT_XML1 | ENT_QUOTES, 'UTF-8');
    }
}
