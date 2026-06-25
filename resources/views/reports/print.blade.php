<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $report['title'] ?? 'Report' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #222;
            margin: 24px;
        }

        h1,
        h2,
        h3 {
            margin-bottom: 8px;
        }

        .meta {
            margin-bottom: 16px;
            color: #555;
        }

        .summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 8px;
            margin-bottom: 16px;
        }

        .card {
            border: 1px solid #ddd;
            padding: 8px 10px;
            border-radius: 6px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background: #f5f5f5;
        }

        .muted {
            color: #666;
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
                <div class="card">
                    <div class="muted">{{ str_replace('_', ' ', $key) }}</div>
                    <div><strong>{{ is_numeric($value) ? number_format($value, 2) : $value }}</strong></div>
                </div>
            @endforeach
        </div>
    @endif

    @if (!empty($report['sections']))
        @foreach ($report['sections'] as $section)
            <h2>{{ $section['title'] }}</h2>
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
    <script>
        window.addEventListener('load', function() {
            window.print();
        });
    </script>
</body>

</html>
