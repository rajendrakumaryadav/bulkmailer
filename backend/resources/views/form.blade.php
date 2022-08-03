<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Simple Form</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx"
          crossorigin="anonymous">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Simple Form</h1>
            <form action="{{ route('form.store') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="col_0">Column 0</label>
                    <select class="form-control" id="col_0" name="col_0">
                        <option value="email">Email</option>
                        <option value="name">Name</option>
                        <option value="date">Date</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="col_1">Column 1</label>
                    <select class="form-control" id="col_1" name="col_1">
                        <option value="email">Email</option>
                        <option value="name">Name</option>
                        <option value="date">Date</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="col_1">Column 2</label>
                    <select class="form-control" id="col_2" name="col_2">
                        <option value="email">Email</option>
                        <option value="name">Name</option>
                        <option value="date">Date</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="submit"
                           class="btn btn-primary btn-lg btn-block submit-button">
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
