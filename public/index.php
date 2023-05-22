<?php
require_once("Database.php");
//require_once("Guid.php");
$database = new Database();

ini_set('display_errors', 1);

// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);

// Reporting E_NOTICE can be good too (to report uninitialized
// letiables or catch letiable name misspellings ...)
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

// Report all errors except E_NOTICE
error_reporting(E_ALL & ~E_NOTICE);

// Report all PHP errors (see changelog)
error_reporting(E_ALL);

// Report all PHP errors
error_reporting(-1);

// Same as error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);


function getGUID()
{
    if (function_exists('com_create_guid')) {
        return com_create_guid();
    } else {
        mt_srand((double) microtime() * 10000); //optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45); // "-"
        $uuid = chr(123) // "{"
            . substr($charid, 0, 8) . $hyphen
            . substr($charid, 8, 4) . $hyphen
            . substr($charid, 12, 4) . $hyphen
            . substr($charid, 16, 4) . $hyphen
            . substr($charid, 20, 12)
            . chr(125); // "}"

        $uuid = trim($uuid, "{");
        $uuid = trim($uuid, "}");
        return $uuid;
    }
}

//$test = getGUID();

$performance = ['very-good' => 5, 'good' => 4, 'ok' => 3, 'bad' => 2, 'very-bad' => 1];
$questions = [
    "q1" => "",
    "q2" => "",
    "q3" => "",
    "q4" => "",
    "q5" => "",
    "q6" => "",
    "q7" => "",
    "q8" => "",
    "q9" => "",
    "q10" => "",
    "q11" => "",
    "q12" => ""
];
$class_id = $classType_id = $subject_id = $faculty_id = $comments = '';
if (
    $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['class']) && isset($_POST['classType']) &&
    isset($_POST['subject']) && isset($_POST['faculty']) && $_POST['class'] != -1 && $_POST['classType'] != -1 &&
    $_POST['subject'] != -1 && $_POST['faculty'] != -1 && isset($_POST["q1"]) && isset($_POST["q2"]) &&
    isset($_POST["q3"]) && isset($_POST["q4"]) && isset($_POST["q5"]) && isset($_POST["q6"]) && isset($_POST["q7"])
    && isset($_POST["q8"]) && isset($_POST["q9"]) && isset($_POST["q10"]) && isset($_POST["q11"])
    && isset($_POST["q12"])
) {

    $class_id = (int)$_POST['class'];
    $classType_id = (int)$_POST['classType'];
    $faculty_id = (int)$_POST['faculty'];
    $subject_id = (int)$_POST['subject'];

    $guid = getGUID();

    foreach (array_keys($questions) as $question) {
        $questions[$question] = $performance[$_POST[$question]];
    }
    $sql = "select fcs_id from faculty_class_subject where class_id = " . $class_id . " and classType_id = " .
        $classType_id . " and faculty_id = " . $faculty_id . " and subject_id = " . $subject_id;

    $fcs_id = (int)$database->getData($sql)[0]['fcs_id'];
    $insert_performance = "insert into Feedback(feedback_id,fcs_id) value(:feedback_id,:fcs_id)";
    $params_feedback = [':fcs_id' => $fcs_id, ':feedback_id' => $guid];
    if (isset($_POST['comments'])) {
        $comments = $_POST['comments'];
        $insert_performance = "insert into Feedback(feedback_id,fcs_id,comments) value(:feedback_id,:fcs_id,:comments)";
        $params_feedback[':comments'] = $comments;
    }

    $stmt = $database->prepare($insert_performance);
    $database->execute($stmt, $params_feedback);

    $insert_performance_Feedback = "insert into Performance_Feedback(performance_id,performance_grade,feedback_id)
                                        value(:performance_id,:performance_grade,:feedback_id)";
   $stmt_performance_Feedback = $database->prepare($insert_performance_Feedback);
    $params_performance_Feedback = [':performance_id' => '', ':performance_grade' => '', ':feedback_id' => $guid];
    foreach (array_keys($questions) as $key) {
        $params_performance_Feedback[':performance_id'] = (int)substr($key,1);
        $params_performance_Feedback[':performance_grade'] = $questions[$key];
        $database->execute($stmt_performance_Feedback,$params_performance_Feedback);
    }

}
?>


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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
    <title>Document</title>

    <script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
</head>

<body>
    <div class="img">
        <a href="http://www.rcti.cteguj.in/" target="_blank">
            <img src="./assets/images/logo.png" alt="Logo" style="height:100px;width:100px;">
        </a>
    </div>
    <nav>
        <div class="heading">
            <p><b>Faculty FeedBack Form</b></p>
        </div>
    </nav>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER[" PHP_SELF"]); ?>
        <div class="DropDown">
            <div class="selection">
                <div class="selec">
                    <select id="semester" name="semester" onchange="getClass()" required>
                        <option value="-1">Select a semester</option>
                    </select>
                    <select id="class" name="class" onchange="getDivision()" required>
                        <option value="-1">Select a class</option>
                    </select>
                    <select id="classType" name="classType" onchange="getDivision()">
                        <option value="-1">Select a Class Type</option>
                        <option value="' . $classType['classType_id'] . '">' . $classType['classType_name'] . "
                        </option>
                    </select>
                    <select id="division" name="division" required onchange="getSubject()">
                        <option value="-1">Select a division</option>
                    </select>
                    <select id="subject" name="subject" onchange="getFaculty()">
                        <option value="-1">Select a Subject</option>
                    </select>
                    <select id="faculty" name="faculty">
                        <option value="-1">Select a faculty</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="frm">
            <div class="questions">
                <div class="qu1">
                    <p class="question">Has the faculty covered entire syllabus as prescribed by
                        University/College/Board?</p>
                    <div class="answer-options">
                        <label>
                            <input type="radio" name="q1" value="very-good" id="very-good">
                            Very Good
                        </label>
                        <label>
                            <input type="radio" name="q1" value="good" id="good">
                            Good
                        </label>
                        <label>
                            <input type="radio" name="q1" value="ok" id="ok">
                            OK
                        </label>
                        <label>
                            <input type="radio" name="q1" value="bad" id="bad">
                            Bad
                        </label>
                        <label>
                            <input type="radio" name="q1" value="very-bad" id="very-bad">
                            Very Bad
                        </label>
                    </div>
                </div>
                <div class="qu2">
                    <p class="question">Has the teacher covered relevant topics beyond syllabus?</p>
                    <div class="answer-options">
                        <label>
                            <input type="radio" name="q2" value="very-good" id="very-good">
                            Very Good
                        </label>
                        <label>
                            <input type="radio" name="q2" value="good" id="good">
                            Good
                        </label>
                        <label>
                            <input type="radio" name="q2" value="ok" id="ok">
                            OK
                        </label>
                        <label>
                            <input type="radio" name="q2" value="bad" id="bad">
                            Bad
                        </label>
                        <label>
                            <input type="radio" name="q2" value="very-bad" id="very-bad">
                            Very Bad
                        </label>
                    </div>
                </div>
                <div class="qu3">
                    <p class="question">Effectiveness of Faculty in terms of Technical Content/Course content
                    </p>
                    <div class="answer-options">
                        <label>
                            <input type="radio" name="q3" value="very-good" id="very-good">
                            Very Good
                        </label>
                        <label>
                            <input type="radio" name="q3" value="good" id="good">
                            Good
                        </label>
                        <label>
                            <input type="radio" name="q3" value="ok" id="ok">
                            OK
                        </label>
                        <label>
                            <input type="radio" name="q3" value="bad" id="bad">
                            Bad
                        </label>
                        <label>
                            <input type="radio" name="q3" value="very-bad" id="very-bad">
                            Very Bad
                        </label>
                    </div>
                </div>
                <div class="qu4">
                    <p class="question">Effectiveness of Faculty in terms of Communication Skills</p>
                    <div class="answer-options">
                        <label>
                            <input type="radio" name="q4" value="very-good" id="very-good">
                            Very Good
                        </label>
                        <label>
                            <input type="radio" name="q4" value="good" id="good">
                            Good
                        </label>
                        <label>
                            <input type="radio" name="q4" value="ok" id="ok">
                            OK
                        </label>
                        <label>
                            <input type="radio" name="q4" value="bad" id="bad">
                            Bad
                        </label>
                        <label>
                            <input type="radio" name="q4" value="very-bad" id="very-bad">
                            Very Bad
                        </label>
                    </div>
                </div>

                <div class="qu5">
                    <p class="question">Effectiveness of Faculty in terms of Use of Teaching aids</p>
                    <div class="answer-options">
                        <label>
                            <input type="radio" name="q5" value="very-good" id="very-good">
                            Very Good
                        </label>
                        <label>
                            <input type="radio" name="q5" value="good" id="good">
                            Good
                        </label>
                        <label>
                            <input type="radio" name="q5" value="ok" id="ok">
                            OK
                        </label>
                        <label>
                            <input type="radio" name="q5" value="bad" id="bad">
                            Bad
                        </label>
                        <label>
                            <input type="radio" name="q5" value="very-bad" id="very-bad">
                            Very Bad
                        </label>
                    </div>
                </div>
                <div class="qu6">
                    <p class="question">Pace on which content were covered</p>
                    <div class="answer-options">
                        <label>
                            <input type="radio" name="q6" value="very-good" id="very-good">
                            Very Good
                        </label>
                        <label>
                            <input type="radio" name="q6" value="good" id="good">
                            Good
                        </label>
                        <label>
                            <input type="radio" name="q6" value="ok" id="ok">
                            OK
                        </label>
                        <label>
                            <input type="radio" name="q6" value="bad" id="bad">
                            Bad
                        </label>
                        <label>
                            <input type="radio" name="q6" value="very-bad" id="very-bad">
                            Very Bad
                        </label>
                    </div>
                </div>
                <div class="qu7">
                    <p class="question">Motivation and inspiration for students to learn</p>
                    <div class="answer-options">
                        <label>
                            <input type="radio" name="q7" value="very-good" id="very-good">
                            Very Good
                        </label>
                        <label>
                            <input type="radio" name="q7" value="good" id="good">
                            Good
                        </label>
                        <label>
                            <input type="radio" name="q7" value="ok" id="ok">
                            OK
                        </label>
                        <label>
                            <input type="radio" name="q7" value="bad" id="bad">
                            Bad
                        </label>
                        <label>
                            <input type="radio" name="q7" value="very-bad" id="very-bad">
                            Very Bad
                        </label>
                    </div>
                </div>
                <div class="qu8">
                    <p class="question">Support for the development of students skill Practical demonstration
                    </p>
                    <div class="answer-options">
                        <label>
                            <input type="radio" name="q8" value="very-good" id="very-good">
                            Very Good
                        </label>
                        <label>
                            <input type="radio" name="q8" value="good" id="good">
                            Good
                        </label>
                        <label>
                            <input type="radio" name="q8" value="ok" id="ok">
                            OK
                        </label>
                        <label>
                            <input type="radio" name="q8" value="bad" id="bad">
                            Bad
                        </label>
                        <label>
                            <input type="radio" name="q8" value="very-bad" id="very-bad">
                            Very Bad
                        </label>
                    </div>
                </div>
                <div class="qu9">
                    <p class="question">Support for the development of students skill Hands on training</p>
                    <div class="answer-options">
                        <label>
                            <input type="radio" name="q9" value="very-good" id="very-good">
                            Very Good
                        </label>
                        <label>
                            <input type="radio" name="q9" value="good" id="good">
                            Good
                        </label>
                        <label>
                            <input type="radio" name="q9" value="ok" id="ok">
                            OK
                        </label>
                        <label>
                            <input type="radio" name="q9" value="bad" id="bad">
                            Bad
                        </label>
                        <label>
                            <input type="radio" name="q9" value="very-bad" id="very-bad">
                            Very Bad
                        </label>
                    </div>
                </div>
                <div class="qu10">
                    <p class="question">Clarity of expectation of students</p>
                    <div class="answer-options">
                        <label>
                            <input type="radio" name="q10" value="very-good" id="very-good">
                            Very Good
                        </label>
                        <label>
                            <input type="radio" name="q10" value="good" id="good">
                            Good
                        </label>
                        <label>
                            <input type="radio" name="q10" value="ok" id="ok">
                            OK
                        </label>
                        <label>
                            <input type="radio" name="q10" value="bad" id="bad">
                            Bad
                        </label>
                        <label>
                            <input type="radio" name="q10" value="very-bad" id="very-bad">
                            Very Bad
                        </label>
                    </div>
                </div>
                <div class="qu11">
                    <p class="question">Feedback provided on students progress</p>
                    <div class="answer-options">
                        <label>
                            <input type="radio" name="q11" value="very-good" id="very-good">
                            Very Good
                        </label>
                        <label>
                            <input type="radio" name="q11" value="good" id="good">
                            Good
                        </label>
                        <label>
                            <input type="radio" name="q11" value="ok" id="ok">
                            OK
                        </label>
                        <label>
                            <input type="radio" name="q11" value="bad" id="bad">
                            Bad
                        </label>
                        <label>
                            <input type="radio" name="q11" value="very-bad" id="very-bad">
                            Very Bad
                        </label>
                    </div>
                </div>

                <div class="qu12">
                    <p class="question">Feedback provided on students progress</p>
                    <div class="answer-options">
                        <label>
                            <input type="radio" name="q12" value="very-good" id="very-good">
                            Very Good
                        </label>
                        <label>
                            <input type="radio" name="q12" value="good" id="good">
                            Good
                        </label>
                        <label>
                            <input type="radio" name="q12" value="ok" id="ok">
                            OK
                        </label>
                        <label>
                            <input type="radio" name="q12" value="bad" id="bad">
                            Bad
                        </label>
                        <label>
                            <input type="radio" name="q12" value="very-bad" id="very-bad">
                            Very Bad
                        </label>
                    </div>
                </div>
                <textarea id="comments" name="comments" placeholder="Your Suggestions"></textarea>
            </div>
        </div>
        <div class="submit">
            <button>Submit</button>
        </div>
    </form>
    <script>

        function onClassType() {
            if ($('#classType').val() == 2) {
                getDivision();
            }
            else {
                getSubject();
            }
        }
        function getClass() {
            let semesterId = document.getElementById("semester").value;
            //alert(semesterId);
            let url = "getClassFromSemester.php";
            let params = "semesterId=" + semesterId;
            let http = new XMLHttpRequest();
            document.getElementById('class').innerHTML = "<option value='-1'>Select Class</option>"
            //document.getElementById('subject').innerHTML = "<option value='-1'>Select Subject</option>"
            document.getElementById('division').innerHTML = "<option value='-1'>Select Division</option>"
            //document.getElementById('Faculty').innerHTML = "<option value='-1'>Select Faculty</option>"
            http.open("GET", url + "?" + params, true);
            http.onreadystatechange = () => {

                if (http.readyState == 4 && http.status == 200) {
                    let res = JSON.parse(http.responseText);
                    for (cnt = 0; cnt < res.length; cnt++) {
                        let opt = res[cnt].class_id;
                        let disp = res[cnt].class_name;
                        $('#class').append($('<option>').attr("value", opt).text(disp));
                    }
                    onClassType();
                }
            }
            http.send(null);
        }

        function getDivision() {
            let classId = document.getElementById("class").value;
            let url = "getDivisionFromClass.php";
            let params = "class_id=" + classId;

            $('#division').empty();
            document.getElementById('division').innerHTML = "<option value='-1'>Select Division</option>"
            //  debugger;
            if ($("#classType").val() == 2) {
                let http = new XMLHttpRequest();
                http.open("GET", url + "?" + params, true);
                http.onreadystatechange = () => {
                    //debugger;

                    if (http.readyState == 4 && http.status == 200) {
                        //console.log(http.responseText);
                        let res = JSON.parse(http.responseText);
                        for (cnt = 0; cnt < res.length; cnt++) {
                            let opt = res[cnt].division_id;
                            let disp = res[cnt].division_name;
                            $('#division').append($('<option>').attr("value", opt).text(disp));
                        }

                        $('#subject').empty();
                        document.getElementById('subject').innerHTML = "<option value='-1'>Select Subject</option>";


                        /*if ($('#classType').value == 2) getSubject();*/
                    }
                }
                http.send(null);
            }
            else {
                getSubject();
            }
        }

        function getSubject() {
            let classId = document.getElementById("class").value;
            let classTypeId = document.getElementById("classType").value;
            let url = "getSubjectFromSemester.php";
            // debugger;
            let params = "class_id=" + classId + "&classType_id=" + classTypeId;
            let http = new XMLHttpRequest();
            console.log($('#classType').value);
            http.open("GET", url + "?" + params, true);
            http.onreadystatechange = () => {

                if (http.readyState == 4 && http.status == 200) {
                    //console.log(http.responseText);
                    //  debugger;
                    $('#subject').empty();
                    document.getElementById('subject').innerHTML = "<option value='-1'>Select Subject</option>";

                    if (http.responseText.length > 0) {
                        let res = JSON.parse(http.responseText);

                        //debugger;
                        //console.log(res);
                        for (cnt = 0; cnt < res.length; cnt++) {
                            $('#subject').append($('<option>').attr("value", res[cnt].subject_id).text(res[cnt].subject_name));
                        }
                    }

                }
            }
            http.send(null);
        }

        function getFaculty() {
            //  debugger;
            let cls = document.getElementById('class').value;
            let classType = document.getElementById('classType').value;
            let subject = document.getElementById('subject').value;
            let division = document.getElementById('division').value;

            let url = "getFaculty.php";
            let params = "class_id=" + cls + "&classType_id=" + classType + "&subject_id=" + subject;

            params += (classType == 2) ? "&division_id=" + division : "&division_id=" + '-1';

            $('#faculty').empty();
            document.getElementById('faculty').innerHTML = "<option value='-1'>Select Faculty</option>";

            let http = new XMLHttpRequest();
            http.open("GET", url + "?" + params, true);
            http.onreadystatechange = () => {
                if (http.readyState == 4 && http.status == 200) {
                    //console.log(http.responseText);
                    debugger;
                    let res = JSON.parse(http.responseText);
                    //debugger;
                    $('#faculty').empty();
                    for (cnt = 0; cnt < res.length; cnt++) {
                        //console.log(res[cnt]);
                        $('#faculty').append($('<option>').attr("value", res[cnt].faculty_id).text(res[cnt].faculty_name));
                    }
                }
            }
            http.send(null);
        }
    </script>

</body>

</html>
