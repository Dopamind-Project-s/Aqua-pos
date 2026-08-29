<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>New Demo Request</title>
</head>
<body style="margin:0;background:#f3f6fa;color:#172033;font-family:Arial,sans-serif;">
    <div style="max-width:680px;margin:0 auto;padding:32px 16px;">
        <div style="background:#ffffff;border-radius:14px;padding:28px;box-shadow:0 8px 28px rgba(15,35,68,.08);">
            <h1 style="margin:0 0 8px;font-size:24px;color:#0d2344;">New Demo Request</h1>
            <p style="margin:0 0 24px;color:#607089;">A new product demo request was submitted through the Aqua POS website.</p>

            <table style="width:100%;border-collapse:collapse;" role="presentation">
                @foreach([
                    'Full name' => $serviceRequest->full_name,
                    'Email' => $serviceRequest->email ?: 'Not provided',
                    'Phone' => $serviceRequest->phone ?: 'Not provided',
                    'Company' => $serviceRequest->company ?: 'Not provided',
                    'Country' => $serviceRequest->country ?: 'Not provided',
                    'Product interest' => $serviceRequest->product_interest ?: 'Not provided',
                    'Branches' => $serviceRequest->branch_count ?: 'Not provided',
                    'Preferred contact time' => $serviceRequest->preferred_contact_time ?: 'Not provided',
                    'Message' => $serviceRequest->message ?: 'Not provided',
                    'Submitted at' => $serviceRequest->created_at?->format('Y-m-d H:i:s'),
                ] as $label => $value)
                    <tr>
                        <th style="padding:10px;border-bottom:1px solid #e8eef6;text-align:left;vertical-align:top;width:38%;color:#34455f;">{{ $label }}</th>
                        <td style="padding:10px;border-bottom:1px solid #e8eef6;text-align:left;vertical-align:top;">{{ $value }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</body>
</html>
