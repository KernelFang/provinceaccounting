<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $report['title'] ?? 'Report' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        h2 {
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
            table-layout: fixed;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
            vertical-align: top;
            word-break: break-word;
        }

        th {
            background: #f5f5f5;
        }

        .summary {
            margin-bottom: 12px;
        }
    </style>
</head>

<body>
    <h2>{{ $report['title'] ?? 'Generated Report' }}</h2>
    <p><strong>Module:</strong> {{ ucfirst($report['module']) }}</p>

    @if (!empty($report['totals']))
        <div class="summary">
            @foreach ($report['totals'] as $key => $value)
                <div><strong>{{ str_replace('_', ' ', $key) }}:</strong>
                    {{ is_numeric($value) ? number_format($value, 2) : $value }}</div>
            @endforeach
        </div>
    @endif

    @if (!empty($report['sections']))
        @foreach ($report['sections'] as $section)
            <h3>{{ $section['title'] }}</h3>
            @if (($section['type'] ?? 'list') === 'summary')
                <table>
                    <tbody>
                        @foreach ($section['rows'] as $row)
                            <tr>
                                <th>{{ $row['label'] }}</th>
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
