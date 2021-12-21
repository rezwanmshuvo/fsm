<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
        <style>
            .hide{
                display: none;
            }
        </style>
    </head>
    <body>

        <div id="show_div">
            <input type="text" id="text" onkeyup="func()">
            <select>
                <option class="option">Select</option>
                <option class="option">ABC</option>
                <option class="option">DEF</option>
                <option class="option">GHI</option>
                <option class="option">JKL</option>
                <option class="option">MNO</option>
                <option class="option">PQR</option>
                <option class="option">STU</option>
                <option class="option">VWX</option>
                <option class="option">YZA</option>
            </select>
        </div>
        <p>This is text</p>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function(){
                $("#text").keyup(function(){
                    let text = $("#text").val().toUpperCase();
                    $(".option").each(function(){
                        if($(this).text().toUpperCase().includes(text)){
                            $(this).show();
                        }
                        else{
                            $(this).hide();
                        }
                    });
                });
            });
        </script>
    </body>
</html>
