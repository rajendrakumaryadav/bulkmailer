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
            <form action="{{ route('form.store') }}" enctype="multipart/form-data"
                  method="post">
                @csrf

                <div class="form-group">
                    <label for="From">
                        From Address<span class="text text-danger">*</span>
                    </label>
                    <br/>
                    <input required
                           autocomplete="off"
                           type="email"
                           class="form-control"
                           id="from"
                           name="from"
                           placeholder="Enter From Address">
                </div>

                <div class="form-group">
                    <label for="From">
                        Sender Name<span class="text text-danger">*</span>
                    </label>
                    <br/>
                    <input required
                           type="text"
                           autocomplete="off"
                           class="form-control"
                           id="sender_name"
                           name="sender_name"
                           placeholder="Enter the Sender Name">
                </div>

                <div class="form-group">
                    <label for="subject">
                        Subject<span class="text text-danger">*</span>
                    </label>
                    <br/>
                    <input required
                           type="text"
                           autocomplete="off"
                           class="form-control"
                           id="subject"
                           name="subject"
                           placeholder="Enter Subject of Mail">
                </div>
                <div class="form-group">
                    <label for="file">
                        File<span class="text text-danger">*</span>
                    </label>
                    <br/>
                    <input
                        required
                        accept="text/csv,.csv"
                        type="file" class="form-control form-control-file"
                        id="file"
                        name="file">
                </div>
                <div class="form-group">
                    <label for="template">
                        Message<span class="text text-danger">*</span>
                    </label>
                    <textarea
                        required
                        class="form-control"
                        id="template"
                        name="template"
                        rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="reply_to">
                        Reply to Address
                    </label>
                    <br/>

                    <input
                        autocomplete="off"
                        type="text"
                        class="form-control"
                        id="reply_to"
                        name="reply_to"
                        placeholder="Enter Reply to Address">
                </div>
                <br/><br/>
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
