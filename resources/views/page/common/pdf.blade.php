<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
    <title>Lịch trình {{ $tour->t_title }}</title>
</head>
<body>
    <h1>Lịch trình {{ $tour->t_title }}</h1>
    <table>
        <thead>
            <tr>
                <th>Ngày</th>
                <th>Tiêu đề</th>
                <th>Mô tả</th>
            </tr>
        </thead>
        <tbody>
            @foreach($itineraries as $itinerary)
                <tr>
                    <td>{{ $itinerary->ti_day }}</td>
                    <td>{{ $itinerary->ti_content }}</td>
                    <td>{!! $itinerary->ti_description !!}
                    <img src="{{ asset(pare_url_file($itinerary->ti_images )) }}" alt="" style="max-width: 100%;"></p></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
