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
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
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
                    <table>
                        <tbody>
                            @foreach ($section['rows'] as $row)
                                <tr>
                                    <td>{{ $row }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            @endif
        @endforeach
    @else
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Label</th>
                    <th>Status</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($report['records'] as $index => $record)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $report['labels'][$index] ?? ($record->name ?? ($record->invoice_no ?? ($record->transaction_reference ?? 'Record'))) }}
                        </td>
                        <td>{{ $record->status ?? ($record->payment_status ?? ($record->clearing_status ?? 'N/A')) }}
                        </td>
                        <td>{{ number_format($record->price ?? ($record->amount ?? 0), 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>

</html>
