<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Create a project</h1>
    <form action="">
        {{csrf_field()}}
        <div class="field">
            <label for="" class="label">Title</label>
            <div class="control">
                <input type="text" class="input">
            </div>
        </div>

        <div class="field">
            <label for="" class="label">Title</label>
            <div class="control">
                <textarea type="text" class="textarea"></textarea>
            </div>
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link">Create Project</button>
            </div>
        </div>

    </form>
</body>
</html>