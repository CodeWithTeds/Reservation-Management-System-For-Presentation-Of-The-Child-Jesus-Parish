<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Reservation Approved</title>
  <style>
    body { font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; color: #111827; }
    .container { max-width: 600px; margin: 0 auto; padding: 24px; }
    .card { border: 1px solid #e5e7eb; border-radius: 12px; padding: 24px; }
    .btn { display: inline-block; background: #2563eb; color: white; padding: 10px 16px; border-radius: 8px; text-decoration: none; }
    .muted { color: #6b7280; font-size: 12px; }
  </style>
</head>
<body>
  <div class="container">
    <div class="card">
      <h2>Hi {{ $user?->name ?? 'there' }}, your reservation has been approved! ✅</h2>
      <p>We're happy to let you know that your reservation request was approved. Here are the details:</p>

      <ul>
        <li><strong>Reservation ID:</strong> #{{ $reservation->reservation_id }}</li>
        <li><strong>Service:</strong> {{ $service?->service_type ?? 'N/A' }}</li>
        <li><strong>Date:</strong> {{ $date }}</li>
        <li><strong>Time:</strong> {{ $time_start }} - {{ $time_end }}</li>
        <li><strong>Status:</strong> {{ $reservation->status }}</li>
        @if ($reservation->remarks)
          <li><strong>Remarks:</strong> {{ $reservation->remarks }}</li>
        @endif
      </ul>

      <p style="margin-top: 20px;">
        <a class="btn" href="{{ url('/client/reservations') }}">View My Reservations</a>
      </p>

      <!-- Extra friendly message added per your request -->
      <div style="margin-top: 20px; padding: 16px; border: 1px solid #e5e7eb; border-radius: 10px; background: #f9fafb;">
        <h3 style="margin: 0 0 8px 0;">Friendly note</h3>
        <p style="margin: 0 0 8px 0;">Thanks for booking with us! We’re excited to see you on <strong>{{ $date }}</strong> from <strong>{{ $time_start }}</strong> to <strong>{{ $time_end }}</strong>.</p>
        <ul style="margin: 0 0 8px 18px;">
          <li>Please arrive at least 10 minutes early.</li>
          <li>Bring a valid ID or booking reference (#{{ $reservation->reservation_id }}).</li>
          <li>If you need to reschedule, reply to this email or manage it in your dashboard.</li>
        </ul>
        <p style="margin: 0;">Need help? Visit your dashboard here: <a href="{{ url('/client/reservations') }}">My Reservations</a></p>
      </div>

      <p class="muted" style="margin-top: 24px;">This is an automated message, please do not reply if not necessary.</p>
    </div>
  </div>
</body>
</html>