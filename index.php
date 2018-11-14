<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="test.css">

</head>
<body>
    <h2></h2>
    <div class="container calculator-box">
        <div class="row">
            <div class="col-xs-12 col-md-6">
                <label for="value_1" class="col-md-3 col-xs-3 col-form-label">Value 1</label>
                <div class="col-md-6 col-xs-3">
                    <input type="number" class="form-control" id="value_1" placeholder="Value 1">
                </div>
            </div>

            <div class="col-xs-12 col-md-6 value-2-box">
                <label for="value_2" class="col-md-3 col-xs-3 col-form-label">Value 2</label>
                <div class="col-md-6 col-xs-3">
                    <input type="number" class="form-control" id="value_2" placeholder="Value 2">
                </div>
            </div>
        </div>

        <div class="row box">
            <div class="col-md-6 col-xs-12">
                 <label for="operation" class="col-md-3 col-xs-3 col-form-label">Operation</label>
                 <div class="col-md-6 col-xs-6">
                    <select class="form-control" id="operation">
                        <option selected>Choose operation</option>
                        <option value="sum">Sum</option>
                        <option value="subtraction">Subtraction</option>
                        <option value="division">Division</option>
                        <option value="multiplication">Multiplication</option>
                    </select>
                 </div>
            </div>

            <div class="col-md-6 col-xs-12 calculate-box">
                <input type="button" id="calculate" class="btn btn-primary" value="Calculate">
            </div>
        </div>

        <div class="row result">
            <div class="col-12 col-sm-6">
                <label for="result" class="col-sm-3 col-form-label">Result</label>
                <div class="col-sm-6">
                    <input type="number" class="form-control" id="result" placeholder="Result" disabled>
                </div>
            </div>
        </div>
        <div class="alert alert-danger" id="error" style="margin: 20px; display: none;"> Error </div>
    </div>


    <script>
        /*
        *   Method to make operation with x and y.
        *   Call PHP method
        *
        *   param int x
        *   param int y
        *   param string operation 
        */
        function calculate(x, y, operation) {
            var values      = [x, y];
            var data        = {values: values, operation: operation};
            var json_data   = JSON.stringify(data);

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax.php", true);
            xhr.setRequestHeader('Content-type','application/json; charset=utf-8');

            xhr.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var result = JSON.parse(this.responseText);
                        $('#error').text('Error when doing the operation');
                        if (result.Status == 'OK') {
                            $('#result').val(result.Result);
                            $('#error').hide('slow');
                        } else {
                            $('#error').show('slow');
                        }
                    }
                }
            xhr.send(json_data);
        }
    </script>
    <script src="jquery.min.js"></script>

    <script type="text/javascript">
        $( document ).ready(function() {
            $('#calculate').on('click', function() {
                var value_1     = $('#value_1').val();
                var value_2     = $('#value_2').val();
                var operation   = $('#operation').val();
                var error       = false;

                /* Validation */
                if ($.isNumeric(value_1) && $.isNumeric(value_2)) {
                    if (operation == 'division' && value_2 == 0) {
                        $('#error').text('Error: Value 2 must be greater than 0');
                        $('#error').show('slow');
                        error = true;
                    }
                    if (!error) {
                        calculate(value_1, value_2, operation);
                    }
                } else {
                    $('#error').text('Error: Invalid values');
                    $('#error').show('slow');
                }
            })
        });
    </script>
</body>

</html>