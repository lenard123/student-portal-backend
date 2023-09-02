<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <style>
        table {
            width: 100%;
        }

        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        th {
            background-color: #d4d4d8;
        }

        td,
        th {
            padding: 12px;
        }

        td {
            padding: 8px;
            border: 0;
            width: 50%;
        }
    </style>
</head>

<body>
    <!-- <table style="margin:auto">
        <tr>
            <td><img height="64" src="http://localhost:9000/logo.png" /></td>
            <td style="font-size: 24px; padding-left: 16px;font-weight: bold">The Lord's Wisdom Academy of Caloocan Inc.</td>
        </tr>
    </table> -->
    <header style="text-align: center;">
        <div>Republic of the Philippines</div>
        <div style="font-size: 24px;">The Lord's Wisdom Academy of Caloocan Inc.</div>
        <div>ENROLLMENT FORM</div>
    </header>

    <main style="margin-top: 36px;">
        <table>
            <tr>
                <th colspan="2">Student General Information</th>
            </tr>
            <tr>
                <td>Name: {{ $enrollee->student->fullname }}</td>
                <td>Student Number: {{ $enrollee->student->info->student_id }}</td>
            </tr>
            <tr>
                <td>Birthday: {{ $enrollee->student->info->birthday }}</td>
                <td>Birthplace: {{ $enrollee->student->info->birthplace }}</td>
            </tr>
            <tr>
                <td>Civil Status: Single</td>
                <td>Religion: {{ $enrollee->student->info->civil_status }}</td>
            </tr>
            <tr>
                <td>Nationality: {{ $enrollee->student->info->nationality }}</td>
                <td>Gender: {{ $enrollee->student->info->gender }}</td>
            </tr>
        </table>

        <table style="margin-top: 16px;">
            <tr>
                <th colspan="2">Pre-Enrollment Information</th>
            </tr>
            <tr>
                <td>Transaction ID: </td>
                <td>{{ $enrollee->transaction_id }}</td>
            </tr>
            <tr>
                <td>School Year: </td>
                <td>{{ $enrollee->academicYear->name }}</td>
            </tr>
            <tr>
                <td>Department: </td>
                <td>{{ $enrollee->academicYear->department }}</td>
            </tr>
            <tr>
                <td>Grade Level: </td>
                <td>{{ $enrollee->gradeLevel->name }}</td>
            </tr>
            <tr>
                <td>Date: </td>
                <td>{{ $enrollee->created_at?->format('Y/m/d') }}</td>
            </tr>
        </table>

        <table style="margin-top: 16px;">
            <tr>
                <th colspan="2">Registration Fees</th>
            </tr>
            @foreach ($enrollee->gradeLevel->fees as $fee)
            <tr>
                <td>{{$fee->fee}}: </td>
                <td>{{$fee->amount}}</td>
            </tr>
            @endforeach
        </table>
    </main>
</body>

</html>