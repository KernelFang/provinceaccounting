<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $report['title'] ?? 'Report' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #1f2937;
            margin: 24px;
            background: #fff;
        }

        .header-card {
            background: linear-gradient(135deg, #f8fafc 0%, #eef2ff 100%);
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 18px 20px;
            margin-bottom: 16px;
        }

        h1,
        h2,
        h3 {
            margin: 0 0 8px 0;
            color: #111827;
        }

        .meta {
            margin-bottom: 10px;
            color: #4b5563;
            font-size: 13px;
        }

        .summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 10px;
            margin-bottom: 16px;
        }

        .card {
            border: 1px solid #e5e7eb;
            background: #f9fafb;
            padding: 10px 12px;
            border-radius: 10px;
        }

        .card .label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .04em;
            color: #6b7280;
            margin-bottom: 4px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
            font-size: 12px;
        }

        th,
        td {
            border: 1px solid #e5e7eb;
            padding: 8px;
            text-align: left;
        }

        th {
            background: #f3f4f6;
            color: #111827;
        }

        .section-title {
            font-size: 14px;
            font-weight: 700;
            margin: 14px 0 8px;
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
                <div class="card">
                    <div class="label">{{ str_replace('_', ' ', $key) }}</div>
                    <div><strong>{{ is_numeric($value) ? number_format($value, 2) : $value }}</strong></div>
                </div>
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
    <script>
        window.addEventListener('load', function() {
            window.print();
        });
    </script>
</body>

</html>
