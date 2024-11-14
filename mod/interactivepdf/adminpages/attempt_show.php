<?php


global $DB, $PAGE, $OUTPUT, $CFG, $USER;

require(__DIR__ . '/../../../config.php');
require_once("$CFG->dirroot/mod/interactivepdf/lib.php");

$id = required_param("id", PARAM_INT); // Course_module ID
$pageid = optional_param('pageid', null, PARAM_INT);
$attemptid = required_param('attemptid', PARAM_INT);
$userid = required_param('studentid', PARAM_INT);

$cm = get_coursemodule_from_id('interactivepdf', $id, 0, false, MUST_EXIST);
$course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
$moduleinstance = $DB->get_record('interactivepdf', array('id' => $cm->instance), '*', MUST_EXIST);

require_login($course, true, $cm);
$context = context_module::instance($cm->id);
$PAGE->set_url('/mod/interactivepdf/studentpages/answer.php', array('attemptid' => $attemptid, 'id' => $id));
$PAGE->set_title("Interactive PDF - Answer Attempt");
$PAGE->requires->css('/mod/interactivepdf/mod_interactivepdf.css');
$PAGE->requires->js_call_amd('mod_interactivepdf/feedback','init',[
    'userid' => $userid,
    'interactivepdfid' => $id,
    'attemptid' => $attemptid,
]);
$pages = $DB->get_records('interactivepdf_pages', ['interactivepdfid' => $id]);

echo $OUTPUT->header();

$sql = "SELECT * FROM {interactivepdf_contents} WHERE page_id = :page_id ORDER BY content_rank ASC";
$params = ['page_id' => $pageid];
$contents = $DB->get_records_sql($sql, $params);

$answers = get_shortquestions_ans($userid, $id, $attemptid, 'shortques');

$html = '';
$count=0;


foreach ($contents as $content) {
    if ($content->type == 'html') {
        $html .= interactivepdf_load_html_content($content, $context);
    }

    if ($content->type == 'shortques') {
        $count++;

        $html .= '<div class="mt-3 question-header">';
        $html .= 'Question ' . $count;
        $html .= '</div>';
        $quesValue = [];
        $quesValue = $DB->get_record('interactivepdf_quizzes', ['content_id' => $content->id]);
        $html .= '<div>';
        $html .= '<div for="question" class="question-body">' . $quesValue->question . '</div>';
        $html .= '</div>';
        $subquestions = $DB->get_records('interactivepdf_subquestions', ['quiz_id' => $quesValue->id]);

        if (!empty($subquestions)) {
            $html .= '<div>';
            foreach ($subquestions as $subquestion) {
                if ($subquestion->type == 'shortques') {
                    $html .= interactivepdf_load_shortquestion_content($id, $subquestion, $userid, $attemptid, 'shortques', 'disabled', 'access', 0,true);
                } elseif ($subquestion->type == '3n') {
                    $html .= interactivepdf_load_3n_table_content($id, $subquestion, $userid, $attemptid, 'disabled', 'access', 0, true);
                } elseif ($subquestion->type == '2nm') {
                    $html .= interactivepdf_load_2nm_table_content($id, $subquestion, $userid, $attemptid, 'disabled', 'access', 0,true);
                }
                elseif ($subquestion->type == '2ns') {
                    $html .= interactivepdf_load_2ns_table_content($id, $subquestion, $userid,$attemptid, 'disabled', 'access', 0,true);
                }

            }
            $html .= '</div>';
        }
    }
}

$html .= '<div class="mt-3">';
$html .= '<div class="d-flex justify-content-between py-1" style="background-color: black; color: white;">';
$html .= '<h6 class="ml-4 mt-2">Overall Feedback</h6>';
$html .= '</div>';
$html .= '<textarea style="border-radius: 0;" class="w-100" name="overall_feedback" id="overall_feedback"></textarea>';
$html .= '</div>';
$html .= '<br>';

$sql = 'select * from {interactivepdf_attempts} where userid = ' . $userid . ' and interactivepdfid = ' . $id . ' order by id DESC Limit 1';
$current_progresses = $DB->get_record_sql($sql);

$html .= '<div class="d-flex justify-content-between py-1">';
if ($current_progresses->student_sign) {
    $html .= '<div>';
    $html .= 'Student\'s Name: '. $current_progresses->student_name .'<br>';
    $html .= 'Student\'s Sign: <br>';
    $html .= '<img src="' . $current_progresses->student_sign . '" alt="Signature" style="width: 200px; height: 100px" >';
    $html .= '</div>';
}

if ($current_progresses->teacher_sign) {
    $html .= '<div>';
    $html .= 'Teacher\'s Name: '. $current_progresses->teacher_name .'<br>';
    $html .= 'Teacher\'s Sign: <br>';
    $html .= '<img src="' . $current_progresses->teacher_sign . '" alt="Signature" style="width: 200px; height: 100px" >';
    $html .= '</div>';
} else {
    $html .= '<div>';
    $html .= '
      <p>Enter Your Name:  </p>
      <input type="text" id="teacher_name" name="teacher_name" value = "'.  $current_progresses->teacher_name .'" alt = "' . $USER->firstname .'" /> <br> <br>
    <p> Your Signature:  </p>
    <div class="d-flex flex-row">
       <div class="wrapper" style="border: 1px solid #4b00ff; border-right: 0;">
           <canvas id="signature-pad" style="background: #fff; width: 100%; height: 100%; cursor: crosshair;" width="400" height="200"></canvas>
       </div>
       <div class="clear-btn" style="display: block;">
           <button type="button" id="clear" style="height: 100%; background: #4b00ff; border: 1px solid transparent; color: #fff; font-weight: 600;cursor: pointer;"><span> Clear </span></button>
       </div>
       <div class="save-btn" style="display: block;">
           <button type="button" id="save" style="height: 100%; background: #2C420676; border: 1px solid transparent; color: #fff; font-weight: 600;cursor: pointer;"><span> Save </span></button>
       </div>
      
   </div>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.3.5/signature_pad.min.js" integrity="sha512-kw/nRM/BMR2XGArXnOoxKOO5VBHLdITAW00aG8qK4zBzcLVZ4nzg7/oYCaoiwc8U9zrnsO9UHqpyljJ8+iqYiQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
       var canvas = document.getElementById("signature-pad");
    
       function resizeCanvas() {
           var ratio = Math.max(window.devicePixelRatio || 1, 1);
           canvas.width = canvas.offsetWidth * ratio;
           canvas.height = canvas.offsetHeight * ratio;
           canvas.getContext("2d").scale(ratio, ratio);
       }
       window.onresize = resizeCanvas;
       resizeCanvas();

       var signaturePad = new SignaturePad(canvas, {
        backgroundColor: "rgb(250,250,250)"
       });

       document.getElementById("clear").addEventListener("click", function(event){
        event.preventDefault();
           signaturePad.clear();
       })
       
       document.getElementById("save").addEventListener("click", function(event){
            event.preventDefault();
            var teacher_name = $("#teacher_name").val();
            var overall_feedback = $("#overall_feedback").val();
            if (signaturePad.isEmpty()) {
                alert("Please provide a signature first.");
            } 
            else if (!teacher_name) {
                alert("Please provide your name.");
            }       
            else if (!overall_feedback) {
                alert("Please provide your overall Feedback!");
            }
            else {
                var signatureData = signaturePad.toDataURL();
                saveSignatureToDatabase(signatureData, teacher_name, overall_feedback);
            }
        });

        function saveSignatureToDatabase(signatureData, teacher_name, overall_feedback) {
            
            fetch("../save_signature.php", { 
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: "signatureData=" + encodeURIComponent(signatureData) + "&username=" + encodeURIComponent(teacher_name) + "&overall_feedback=" + encodeURIComponent(overall_feedback) + "&userid=" + encodeURIComponent(' . $userid . ') + "&interactivepdfid=" + encodeURIComponent(' . $id . ')+ "&attempt=" + encodeURIComponent(' . $attemptid . ') + "&type=" + encodeURIComponent("teacher") 
            })
            .then(function(response) {
                return response.text();
            })
            .then(function(result) {
                $("#final_feedback_submit").removeClass("d-none");
            })
            .catch(function(error) {
                console.error("Error:", error);
            });
        }
   </script>
   ';
    $html .= '</div>';
}
$html .= '</div>';
$url = new moodle_url('/mod/interactivepdf/submit_feedback.php');

$display = (object)[
    'formurl' => $url,
    'content' => $html,
    'cmid' => $id,
    'attemptid'=>$attemptid,
    'pageid'=>$pageid,
    'studentid'=>$userid,
];
echo $OUTPUT->render_from_template('mod_interactivepdf/feedback', $display);
echo $OUTPUT->footer();