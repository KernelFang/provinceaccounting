<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $report['title'] ?? 'Report' }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #1f2937;
            background: #fff;
        }

        .header-card {
            background: linear-gradient(135deg, #f8fafc 0%, #eef2ff 100%);
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 16px 18px;
            margin-bottom: 16px;
        }

        h1 {
            font-size: 22px;
            margin: 0 0 8px 0;
            color: #111827;
        }

        .meta {
            margin-bottom: 6px;
            color: #4b5563;
            font-size: 12px;
        }

        .summary {
            margin-bottom: 16px;
        }

        .summary div {
            margin-bottom: 6px;
            padding: 6px 8px;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
            table-layout: fixed;
        }

        th,
        td {
            border: 1px solid #e5e7eb;
            padding: 7px;
            text-align: left;
            vertical-align: top;
            word-break: break-word;
        }

        th {
            background: #f3f4f6;
            color: #111827;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin-top: 12px;
            margin-bottom: 8px;
            color: #111827;
        }
    </style>
</head>

<body>
    <div class="header-card">
        <h1>{{ $report['title'] ?? 'Generated Report' }}</h1>
        <div class="meta">
            <div><strong>Module:</strong> {{ ucfirst($report['module']) }}</div>
            <div><strong>Item:</strong> {{ $report['item_label'] ?? 'N/A' }}</div>
        </div>
    </div>

    @if (!empty($report['totals']))
        <div class="summary">
            @foreach ($report['totals'] as $key => $value)
                <div><strong>{{ str_replace('_', ' ', ucfirst($key)) }}:</strong>
                    {{ is_numeric($value) ? number_format($value, 2) : $value }}</div>
            @endforeach
        </div>
    @endif

    @if (!empty($report['sections']))
        @foreach ($report['sections'] as $section)
            <div class="section-title">{{ $section['title'] }}</div>
            @if (($section['type'] ?? 'list') === 'summary')
                <table>
                    <tbody>
                        @foreach ($section['rows'] as $row)
                            <tr>
                                <th style="width: 30%">{{ $row['label'] }}</th>
                                <td>{{ $row['value'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                @if (!empty($section['rows']))
                    @php
                        $tableRows = collect($section['rows']);
                        $firstRow = $tableRows->first();
                        $isStructuredRows = is_array($firstRow) || is_object($firstRow);
                        $tableColumns = $section['columns'] ?? [];

                        if ($isStructuredRows && empty($tableColumns)) {
                            $tableColumns = array_keys((array) $firstRow);
                        }
                    @endphp

                    <table>
                        <thead>
                            <tr>
                                @if ($isStructuredRows)
                                    @foreach ($tableColumns as $columnKey => $columnLabel)
                                        <th>{{ is_int($columnKey) ? ucwords(str_replace('_', ' ', $columnLabel)) : $columnLabel }}
                                        </th>
                                    @endforeach
                                @else
                                    <th>Item</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tableRows as $row)
                                <tr>
                                    @if ($isStructuredRows)
                                        @foreach ($tableColumns as $columnKey => $columnLabel)
                                            @php $columnName = is_int($columnKey) ? $columnLabel : $columnKey; @endphp
                                            <td>{{ data_get($row, $columnName, '') }}</td>
                                        @endforeach
                                    @else
                                        <td>{{ $row }}</td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            @endif
        @endforeach
    @else
        @php
            $tableHeaders = $report['table_headers'] ?? [];
            $tableRows = $report['table_rows'] ?? [];
        @endphp

        @if (!empty($tableRows))
            <table>
                <thead>
                    <tr>
                        @foreach ($tableHeaders as $header)
                            <th>{{ $header }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tableRows as $row)
                        <tr>
                            @foreach ($row as $cell)
                                <td>{{ $cell }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @endif
</body>

</html>
