<!-- resources/views/students/index.blade.php -->

<h1>Students and Their Branches</h1>

<table>
    <thead>
        <tr>
            <th>Full Name</th>
            <th>Grade</th>
            <th>Enrollment Date</th>
            <th>Status</th>
            <th>Branch</th>
        </tr>
    </thead>
    <tbody>
        @foreach($students as $student)
            <tr>
                <td>{{ $student->fullname }}</td>
                <td>{{ $student->grade }}</td>
                <td>{{ $student->enrollment_date }}</td>
                <td>{{ $student->status }}</td>
                <td>{{ $student->branch->name }}</td>
            </tr>
        @endforeach
    </tbody>
</table>