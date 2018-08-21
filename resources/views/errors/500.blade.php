<!DOCTYPE html>
<html>
    <head>
        <title>Error!</title>

        <link href="{{ URL::asset('template/assets/fonts/open-sans/open-sans.css') }}" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #B0BEC5;
                display: table;
                font-weight: 100;
                font-family: 'Open Sans', sans-serif;
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 72px;
                margin-bottom: 40px;
            }

            .title a {
                text-decoration: none;
                color: #B0BEC5
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title" style="margin-bottom:10px;color:#EC6F5A">Something went wrong!</div>
                <div class="title" style="font-size:36px"><a href="javascript:window.history.back()">Click here to go back!</a></div>
            </div>
        </div>
    </body>
</html>
