<html>
<head>
    <title>{{ env('WEB_PAGE_TITLE') }}</title>

    <link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>

    <style>
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            color: #B0BEC5;
            display: table;
            font-weight: 100;
            font-family: 'Lato';
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
            font-size: 96px;
            margin-bottom: 40px;
        }

        .quote {
            font-size: 24px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="content">
        <div class="title">{{ env('WEB_GROUP_NAME') }}</div>
        <div class="quote">Nothing to see here yet.</div>
    </div>
</div>
</body>
</html>
