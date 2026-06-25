<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $report['title'] ?? 'Report' }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #222;
        }

        h1 {
            font-size: 22px;
            margin-bottom: 8px;
        }

        .meta {
            margin-bottom: 16px;
            color: #444;
        }

        .summary {
            margin-bottom: 16px;
        }

        .summary div {
            margin-bottom: 4px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 7px;
            text-align: left;
        }

        th {
            background: #f5f5f5;
        }

        .section-title {
            font-size: 15px;
            font-weight: bold;
            margin-top: 12px;
            margin-bottom: 8px;
        }
    </style>
</head>

<body>
    <h1>{{ $report['title'] ?? 'Generated Report' }}</h1>
    <div class="meta">
        <div><strong>Module:</strong> {{ ucfirst($report['module']) }}</div>
        <div><strong>Item:</strong> {{ $report['item_label'] ?? 'N/A' }}</div>
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
