<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/assets/images/logo.ico" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ysabeau:wght@300&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <title>Document</title>
</head>

<body> 
    <div class="img">
        <a href="http://www.rcti.cteguj.in/" target="_blank">
            <img src="/assets/images/logo.jpg" alt="Logo" height="100px" width="100px">
        </a>
    </div>
    <nav>
        <div class="heading">
            <h2><b>Faculty FeedBack Form</b></h2>
        </div>
    </nav>
    <div class="DropDown">
        <div class="selection">
            <div class="selec">
                <select id="semester" onchange="updateClassList()">
                    <option value="">Select a semester</option>
                    <option value="sem2">Semester 2</option>
                    <option value="sem4">Semester 4</option>
                    <option value="sem6">Semester 6</option>
                </select>
                <select id="class" onchange="updateSubjectList()">
                    <option value="">Select a class</option>
                </select>
            </div>
            <div class="selec1">
                <select id="subject" onchange="updateFacultyList()">
                    <option value="">Select a Lab</option>
                </select>
                <select id="faculty">
                    <option value="">Select a faculty</option>
                </select>
            </div>
        </div>
    </div>
    <div class="frm">
        <div class="questions">
            <div class="qu1">
                <p class="question">What is your favorite color?</p>
                <div class="answer-options">
                    <label>
                        <input type="radio" name="feedback" value="very-good" id="very-good">
                        Very Good
                    </label>
                    <label>
                        <input type="radio" name="feedback" value="good" id="good">
                        Good
                    </label>
                    <label>
                        <input type="radio" name="feedback" value="ok" id="ok">
                        OK
                    </label>
                    <label>
                        <input type="radio" name="feedback" value="bad" id="bad">
                        Bad
                    </label>
                    <label>
                        <input type="radio" name="feedback" value="very-bad" id="very-bad">
                        Very Bad
                    </label>
                </div>
            </div>
            <div class="qu2">
                <p class="question">What is your favorite color?</p>
                <div class="answer-options">
                    <label>
                        <input type="radio" name="feedback" value="very-good" id="very-good">
                        Very Good
                    </label>
                    <label>
                        <input type="radio" name="feedback" value="good" id="good">
                        Good
                    </label>
                    <label>
                        <input type="radio" name="feedback" value="ok" id="ok">
                        OK
                    </label>
                    <label>
                        <input type="radio" name="feedback" value="bad" id="bad">
                        Bad
                    </label>
                    <label>
                        <input type="radio" name="feedback" value="very-bad" id="very-bad">
                        Very Bad
                    </label>
                </div>
            </div>
            <div class="qu3">
                <p class="question">What is your favorite color?</p>
                <div class="answer-options">
                    <label>
                        <input type="radio" name="feedback" value="very-good" id="very-good">
                        Very Good
                    </label>
                    <label>
                        <input type="radio" name="feedback" value="good" id="good">
                        Good
                    </label>
                    <label>
                        <input type="radio" name="feedback" value="ok" id="ok">
                        OK
                    </label>
                    <label>
                        <input type="radio" name="feedback" value="bad" id="bad">
                        Bad
                    </label>
                    <label>
                        <input type="radio" name="feedback" value="very-bad" id="very-bad">
                        Very Bad
                    </label>
                </div>
            </div>
            <div class="qu4">
                <p class="question">What is your favorite color?</p>
                <div class="answer-options">
                    <label>
                        <input type="radio" name="feedback" value="very-good" id="very-good">
                        Very Good
                    </label>
                    <label>
                        <input type="radio" name="feedback" value="good" id="good">
                        Good
                    </label>
                    <label>
                        <input type="radio" name="feedback" value="ok" id="ok">
                        OK
                    </label>
                    <label>
                        <input type="radio" name="feedback" value="bad" id="bad">
                        Bad
                    </label>
                    <label>
                        <input type="radio" name="feedback" value="very-bad" id="very-bad">
                        Very Bad
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="submit">
        <button>Submit</button>
    </div>
    <script src="/js/app.js"></script>
</body>
</html>
