<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="main.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
     
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
  
<script>tinymce.init({selector:'textarea'});</script>
<style>
        .header {
            background-color: #4CAF50;
            padding: 20px;
            text-align: center;
            color: white;
            font-size: 30px;
        }
    
        .exam-table {
            padding: 20px;
        }

        .question-text {
            font-weight: bold;
        }

        .question-photo {
            max-width: 300px;
            max-height: 300px;
        }

        .form-group {
            padding-left: 1rem;
        }

        .submit-section {
            padding: 20px;
        }
        
        .btn {
            border: none;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            transition-duration: 0.4s;
            cursor: pointer;
            border-radius: 8px;
        }

        .btn-warning {
            background-color: #f44336;
            color: white;
        }

        .btn-warning:hover {
            background-color: #da190b;
        }

        .btn-primary {
            background-color: #4CAF50;
            color: white;
        }

        .btn-primary:hover {
            background-color: #45a049;
        }

        .float-right {
            float: right;
        }
    </style>


</head>
<body>
<div class="header" style="background-color: #4CAF50; padding: 20px; text-align: center; color: white; font-size: 30px;">
    <?php
        require_once('database.php');
        $examId = $_GET['exam_id'];
        $sql = "SELECT exam_title FROM exam_tbl WHERE ex_id='$examId'";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo '<h2>' . $row['exam_title'] . '</h2>';
        } else {
            echo '<h2>Exam Title</h2>'; // Default title if the database query fails
        }
    ?>
</div>


<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="col-md-12">
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                       
                    </div>
                    <div class="page-title-actions mr-5" style="font-size: 20px;">
                        <form name="cd">
                            <input type="hidden" name="" id="timeExamLimit" value="">
                            <label>Remaining Time : </label>
                            <input style="border:none;background-color: transparent;color:blue;font-size: 25px;" name="disp" type="text" class="clock" id="txt" value="00:00" size="5" readonly="true" />
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 p-0 mb-4">
            <form method="post" action="submit-questions.php?exam_id=<?php echo $examId; ?>">
                <input type="hidden" name="exam_id" id="exam_id" value="">
                <input type="hidden" name="examAction" id="examAction">
                <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="tableList">
                  <?php
    // Replace with your database connection details
    require_once('database.php');

    $examId = $_GET['exam_id'];
    $sql = "SELECT * FROM exam_question_tbl WHERE ex_id='$examId'";
    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            $i = 1;
            while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td>
                        <p><b><?php echo $i++ . ".) " . $row['exam_question']; ?></b></p>
                         <!-- Display marks here -->
                    <p>Marks: <?php echo $row['marks']; ?></p>
                        <?php if ($row['photo'] !== '') { ?>
                            <img src="<?php echo '/exam/adminpanel/page/uploads/' . $row['photo']; ?>" alt="Question Photo" style="max-width: 300px; max-height: 300px;">
                        <?php } ?>
                        <div class="col-md-4 float-left">
                            <div class="form-group pl-4">
                                <?php if ($row['question_type'] === 'single_choice' || $row['question_type'] === 'multiple_choice') { ?>
                                    <input type="hidden" name="question_type[<?php echo $row['eqt_id']; ?>]" value="<?php echo $row['question_type']; ?>">
                                    <?php if ($row['question_type'] === 'single_choice') { ?>
                                        <input name="answer[<?php echo $row['eqt_id']; ?>]" class="form-check-input" type="radio" value="<?php echo $row['exam_ch1']; ?>" id="option1_<?php echo $row['eqt_id']; ?>">
    <label class="form-check-label" for="option1_<?php echo $row['eqt_id']; ?>">
        <?php echo $row['exam_ch1']; ?>
    </label>
    <br>
    <input name="answer[<?php echo $row['eqt_id']; ?>]" class="form-check-input" type="radio" value="<?php echo $row['exam_ch2']; ?>" id="option2_<?php echo $row['eqt_id']; ?>">
    <label class="form-check-label" for="option2_<?php echo $row['eqt_id']; ?>">
        <?php echo $row['exam_ch2']; ?>
    </label>
    <br>
    <input name="answer[<?php echo $row['eqt_id']; ?>]" class="form-check-input" type="radio" value="<?php echo $row['exam_ch3']; ?>" id="option3_<?php echo $row['eqt_id']; ?>">
    <label class="form-check-label" for="option3_<?php echo $row['eqt_id']; ?>">
        <?php echo $row['exam_ch3']; ?>
    </label>
    <br>
    <input name="answer[<?php echo $row['eqt_id']; ?>]" class="form-check-input" type="radio" value="<?php echo $row['exam_ch4']; ?>" id="option4_<?php echo $row['eqt_id']; ?>">
    <label class="form-check-label" for="option4_<?php echo $row['eqt_id']; ?>">
        <?php echo $row['exam_ch4']; ?>
    </label>
    <br>
                                 <!-- Add similar code for other options if available -->
<?php } elseif ($row['question_type'] === 'multiple_choice') { ?>
    <input name="answer[<?php echo $row['eqt_id']; ?>][]" class="form-check-input" type="checkbox" value="<?php echo $row['exam_ch1']; ?>" id="option1_<?php echo $row['eqt_id']; ?>">
    <label class="form-check-label" for="option1_<?php echo $row['eqt_id']; ?>">
        <?php echo $row['exam_ch1']; ?>
    </label>
    <br>
    <input name="answer[<?php echo $row['eqt_id']; ?>][]" class="form-check-input" type="checkbox" value="<?php echo $row['exam_ch2']; ?>" id="option2_<?php echo $row['eqt_id']; ?>">
    <label class="form-check-label" for="option2_<?php echo $row['eqt_id']; ?>">
        <?php echo $row['exam_ch2']; ?>
    </label>
    <br>
    <!-- Add similar code for other options if available -->
    <input name="answer[<?php echo $row['eqt_id']; ?>][]" class="form-check-input" type="checkbox" value="<?php echo $row['exam_ch3']; ?>" id="option3_<?php echo $row['eqt_id']; ?>">
    <label class="form-check-label" for="option3_<?php echo $row['eqt_id']; ?>">
        <?php echo $row['exam_ch3']; ?>
    </label>
    <br>
    <input name="answer[<?php echo $row['eqt_id']; ?>][]" class="form-check-input" type="checkbox" value="<?php echo $row['exam_ch4']; ?>" id="option4_<?php echo $row['eqt_id']; ?>">
    <label class="form-check-label" for="option4_<?php echo $row['eqt_id']; ?>">
        <?php echo $row['exam_ch4']; ?>
    </label>
    <br>
<?php } ?>


                                                <?php } elseif ($row['question_type'] === 'essay') { ?>
    <div class="form-group pl-4">
    <input type="hidden" name="question_type" value="essay">

        <textarea id="essayQuestion_<?php echo $row['eqt_id']; ?>" name="answer[<?php echo $row['eqt_id']; ?>]" rows="4" cols="50"></textarea>
    </div>
<?php } ?>



                                        </div>
                                    </td>
                                </tr>
                            <?php }
                        } else { ?>
                            <tr>
                                <td>
                                    <b>No questions at this moment</b>
                                </td>
                            </tr>
                        <?php }
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                    $conn->close();
                    ?>
                    <tr>
                        <td style="padding: 20px;">
                            <button type="button" class="btn btn-xlg btn-warning p-3 pl-4 pr-4" id="resetExamFrm">Reset</button>

                            <input name="submit" type="submit" value="Submit" class="btn btn-xlg btn-primary p-3 pl-4 pr-4 float-right" id="submitAnswerFrmBtn">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
<script>
    tinymce.init({
        selector: '#essayQuestion_<?php echo $row['eqt_id']; ?>',
        plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        toolbar_mode: 'floating',
        tinycomments_mode: 'embedded',
        tinycomments_author: 'Author name'
    });
</script>

</body>
</html>