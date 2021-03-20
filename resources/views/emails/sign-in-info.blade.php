<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
  <h1>{{ $details['title'] }}</h1>
  <hr>
  <p>Please keep this your brief data</p>
  <table>
    <tr>
      <td>Email</td>
      <td>:</td>
      <td>{{ $details['body']['email'] }}</td>
    </tr>
    <tr>
      <td>Password</td>
      <td>:</td>
      <td>{{ $details['body']['password'] }}</td>
    </tr>
  </table>
</body>
</html>