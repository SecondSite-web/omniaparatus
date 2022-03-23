<?php
/**
 * Created by PhpStorm.
 * User: grego
 * Date: 7/19/2019
 * Time: 9:21 AM
 */

?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Registration Form</title>
</head>
<body>
    <div class="container">
  <div class="panel panel-default">
    <div class="panel-body">
      <form data-smk-icon="glyphicon-remove-sign">
        <div class="form-group">
          <label class="control-label">Text</label>
          <input type="text" class="form-control" placeholder="Enter text" required>
        </div>
        <div class="form-group">
          <label class="control-label">Disabled input (not validate)</label>
          <input type="text" class="form-control" disabled required>
        </div>
        <div class="form-group">
          <label class="control-label">Select</label>
          <select class="form-control" required>
            <option value="">Select</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
          </select>
        </div>
        <div class="form-group">
          <label class="control-label">Email</label>
          <input type="email" class="form-control" placeholder="alfredobarronc@gmail.com" required>
        </div>
        <div class="form-group">
          <label class="control-label">Alphanumeric</label>
          <input type="text" class="form-control" data-smk-type="alphanumeric" required>
        </div>
        <div class="form-group">
          <label class="control-label">Number (type number)</label>
          <input type="number" class="form-control" required>
        </div>
        <div class="form-group">
          <label class="control-label">Number (not required)</label>
          <input type="text" class="form-control" data-smk-type="number">
        </div>
        <div class="form-group">
          <label class="control-label">Number (2015-2020)</label>
           <input type="text" class="form-control" data-smk-type="number" data-smk-min="2015" data-smk-max="2020" required>
        </div>
        <div class="form-group">
          <label class="control-label">Decimal</label>
          <input type="text" class="form-control" placeholder="10.00" data-smk-type="decimal" required>
        </div>
        <div class="form-group">
          <label class="control-label">Currency</label>
          <div class="input-group">
            <span class="input-group-addon">$</span>
            <input type="text" class="form-control" placeholder="1,000.00" data-smk-type="currency" required>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label">Number Character (8)</label>
          <input type="text" class="form-control" minlength="8" maxlength="8" required>
        </div>
        <div class="form-group">
          <label class="control-label">Range Character (4-8)</label>
          <input type="text" class="form-control" minlength="4" maxlength="8" required>
        </div>
        <div class="form-group">
          <label class="control-label">Password</label>
          <div class="input-group">
            <input type="password" class="form-control" data-smk-strongPass="medium" id="pass1" required>
            <span class="input-group-addon">medium</span>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label">Confirm Password</label>
          <input type="password" class="form-control" id="pass2">
        </div>
        <div class="form-group">
          <label class="control-label">URL</label>
          <input type="url" class="form-control" placeholder="http://alfredobarron.com" required>
        </div>
        <div class="form-group">
          <label class="control-label">Tel</label>
          <input type="tel" class="form-control" placeholder="0123456789" required>
        </div>
        <div class="form-group">
          <label class="control-label">Color</label>
          <input type="color" class="form-control" required>
        </div>
        <div class="form-group">
          <label class="control-label">Date</label>
          <input type="date" class="form-control" required>
        </div>
        <div class="form-group">
          <label class="control-label">Datetime</label>
          <input type="datetime" class="form-control" placeholder="1996-12-19T16:39:57-08:00" required>
        </div>
        <div class="form-group">
          <label class="control-label">Time</label>
          <input type="time" class="form-control" required>
        </div>
        <div class="form-group">
          <label class="control-label">Month</label>
          <input type="month" class="form-control" required>
        </div>
        <div class="form-group">
          <label class="control-label">Week</label>
          <input type="week" class="form-control" required>
        </div>
        <div class="form-group">
          <label class="control-label">Pattern</label>
          <input type="text" class="form-control" placeholder="Enter 3 character from 'a' to 'z'" data-smk-pattern="[a-z]{3}" required>
        </div>
        <div class="form-group">
          <label class="control-label">Textarea</label>
          <textarea class="form-control" rows="3" required></textarea>
        </div>
        <div class="form-group">
          <div class="checkbox">
            <label>
              <input type="checkbox" name="check" value="1" required>
              Checkbox
            </label>
          </div>
        </div>
        <div class="form-group">
          <div class="radio">
            <label>
              <input type="radio" name="rad" value="option1" required>
              Option 1
            </label>
          </div>
          <div class="radio">
            <label>
              <input type="radio" name="rad" value="option2" required>
              Option 2
            </label>
          </div>
        </div>
        <button type="button" class="btn btn-default" id="btnClear">Clear</button>
        <button type="submit" class="btn btn-default" id="btnSubmit">Submit</button>
      </form>
    </div>
  </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="form-validate.js"></script>
</body>
</html>