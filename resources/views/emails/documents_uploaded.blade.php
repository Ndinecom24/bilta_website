<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Documents Uploaded</title>
</head>
<body style="font-family: Arial, sans-serif; color: #1f2937; line-height: 1.6;">
    <p>Hello {{ $recipient->name }},</p>

    <p><strong>{{ $uploader->name }}</strong> uploaded new file(s) in the folder <strong>{{ $folder->name }}</strong>.</p>

    @if(!empty($description))
        <p><strong>Message:</strong> {{ $description }}</p>
    @endif

    <p><strong>Uploaded files:</strong></p>
    <ul>
        @foreach($documents as $doc)
            <li>{{ $doc->original_name }}</li>
        @endforeach
    </ul>

    <p>
        You can view these documents here:<br>
        <a href="{{ route('employee.documents') }}">Open My Documents</a>
    </p>

    <p>Regards,<br>Bilta Team</p>
</body>
</html>
